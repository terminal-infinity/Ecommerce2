<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Http\Request;

class MollieController extends Controller{
    public function confirmOrder(Request $request){
    $user = Auth::user();
    $cartItems = Cart::where('user_id', $user->id)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    // Validate request inputs
    $request->validate([
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'payment_method' => 'required|in:cod,online',
    ]);

    $paymentMethod = $request->input('payment_method');

    if ($paymentMethod === 'cod') {
        // Handle COD
        foreach ($cartItems as $item) {
            $order = new Order();
            $order->name = $user->name;
            $order->address = $request->input('address', $user->address);
            $order->phone = $request->input('phone', $user->phone);
            $order->user_id = $user->id;
            $order->product_id = $item->product_id;
            $order->product_name = $item->product->title;
            $order->amount = $item->product->price;
            $order->order_id = 'ORD' . strtoupper(uniqid());
            $order->status = 'Pending Payment';
            $order->currency = 'BDT';
            $order->save();
        }

        // Clear user's cart
        Cart::where('user_id', $user->id)->delete();

        return redirect('/myorders')->with('success', 'Order placed successfully with Cash on Delivery.');
    }

    if ($paymentMethod === 'online') {
        // Calculate total amount dynamically
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price;
        });

        try {
            // Prepare payment with Mollie
            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => "BDT",
                    "value" => number_format($totalAmount, 2, '.', ''), // Format to two decimals
                ],
                "description" => "Order Payment for User ID: {$user->id}",
                "redirectUrl" => route('order.success'),
                "metadata" => [
                    "user_id" => $user->id,
                    "cart_id" => $cartItems->pluck('id')->toArray(), // Store cart info
                    "order_id" => 'ORD' . strtoupper(uniqid()),
                ],
            ]);

            // Redirect to Mollie checkout page
            return redirect($payment->getCheckoutUrl(), 303);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create payment. Please try again.');
        }
    }

    return redirect()->back()->with('error', 'Invalid payment method selected.');
}


public function paymentSuccess(Request $request)
{
    $paymentId = $request->input('id'); // Mollie payment ID
    $payment = Mollie::api()->payments->get($paymentId);

    if ($payment->isPaid()) {
        // Retrieve metadata
        $userId = $payment->metadata->user_id;
        $cartIds = $payment->metadata->cart_id;

        // Process orders and payments
        foreach ($cartIds as $cartId) {
            $cartItem = Cart::find($cartId);
            if ($cartItem) {
                $order = new Order();
                $order->name = Auth::user()->name;
                $order->address = Auth::user()->address;
                $order->phone = Auth::user()->phone;
                $order->user_id = $userId;
                $order->product_id = $cartItem->product_id;
                $order->product_name = $cartItem->product->title;
                $order->amount = $cartItem->product->price;
                $order->order_id = 'ORD' . strtoupper(uniqid());
                $order->transaction_id = $paymentId;
                $order->status = 'Paid';
                $order->currency = 'EUR';
                $order->save();

                // Remove cart item
                $cartItem->delete();
            }
        }

        return redirect('/myorders')->with('success', 'Payment successful and order placed.');
    }

    return redirect('/cart')->with('error', 'Payment failed. Please try again.');
}


public function webhookHandler(Request $request)
{
    $paymentId = $request->input('id');
    $payment = Mollie::api()->payments->get($paymentId);

    if ($payment->isPaid()) {
        // Payment is successful, handle accordingly
        // Similar logic as `paymentSuccess` can be implemented
    }
}


}
