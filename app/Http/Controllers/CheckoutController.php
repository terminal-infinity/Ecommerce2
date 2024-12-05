<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    // Place an order
    public function OrderPlace(Request $request)
    {
        $request->validate([
            'c_name' => 'required|string|max:255',
            'c_phone' => 'required|string|max:15',
            'c_country' => 'required|string|max:255',
            'c_address' => 'required|string|max:500',
            'c_email' => 'required|email|max:255',
            'c_zipcode' => 'nullable|string|max:20',
            'c_city' => 'required|string|max:255',
            'payment_type' => 'required|in:Hand cash,Aamarpay',
        ]);

        if ($request->payment_type == "Hand cash") {
            $this->processHandCashOrder($request);
            $notification = [
                'messege' => 'Order placed successfully!',
                'alert-type' => 'success'
            ];
            return redirect()->to('/')->with($notification);
        } elseif ($request->payment_type == "Aamarpay") {
            return $this->processAamarpayOrder($request);
        }
    }

    private function processHandCashOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        // Calculate total amount dynamically
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price;
        });
        $order = [
            'user_id' => Auth::id(),
            'c_name' => $request->c_name,
            'c_phone' => $request->c_phone,
            'c_country' => $request->c_country,
            'c_address' => $request->c_address,
            'c_email' => $request->c_email,
            'c_zipcode' => $request->c_zipcode,
            'c_city' => $request->c_city,
            'subtotal' => $totalAmount,
            'coupon_code' => Session::get('coupon')['name'] ?? null,
            'coupon_discount' => Session::get('coupon')['discount'] ?? 0,
            'after_discount' => Session::get('coupon')['after_discount'] ?? $totalAmount,
            'total' => $totalAmount,
            'payment_type' => $request->payment_type,
            'shipping_charge' => 0,
            'order_id' => rand(10000, 900000),
            'status' => 0,
            'date' => date('d-m-Y'),
        ];

        $order_id = DB::table('orders')->insertGetId($order);

        $this->saveOrderDetails($order_id);
        // Clear user's cart
        Cart::where('user_id', $user->id)->delete();
        Session::forget('coupon');
    }

    private function processAamarpayOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        // Calculate total amount dynamically
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price;
        });
        $aamarpay = DB::table('payments')->first();

        if (!$aamarpay || !$aamarpay->store_id) {
            $notification = [
                'messege' => 'Please set up your payment gateway.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $url = $aamarpay->status == 1 
            ? 'https://secure.aamarpay.com/request.php'
            : 'https://sandbox.aamarpay.com/request.php';

        $tran_id = "test" . rand(1111111, 9999999);
        $data = [
            "store_id" => $aamarpay->store_id,
            "tran_id" => $tran_id,
            "success_url" => route('success'),
            "fail_url" => route('fail'),
            "cancel_url" => route('cancel'),
            "amount" => $totalAmount,
            "currency" => "BDT",
            "signature_key" => $aamarpay->signature_key,
            "desc" => "Order Payment",
            "cus_name" => $request->c_name,
            "cus_email" => $request->c_email,
            "cus_add1" => $request->c_address,
            "cus_city" => $request->c_city,
            "cus_country" => $request->c_country,
            "cus_phone" => $request->c_phone,
        ];

        $response = $this->makeAamarpayRequest($url, $data);

        if (isset($response->payment_url) && !empty($response->payment_url)) {
            return redirect()->away($response->payment_url);
        } else {
            return redirect()->back()->with('error', 'Payment gateway error.');
        }
    }

    private function makeAamarpayRequest($url, $data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    private function saveOrderDetails($order_id)
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();
    
        foreach ($cartItems as $item) {
            $details = [
                'order_id' => $order_id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'color' => $item->color,
                'size' => $item->size,
                'quantity' => $item->quantity,
                'single_price' => $item->price,
                'subtotal_price' => $item->price * $item->quantity,
            ];
            DB::table('order_details')->insert($details);
        }
    
        // Clear cart after order
        Cart::where('user_id', $userId)->delete();
    }
    

    public function success(Request $request)
    {
        $request_id = $request->mer_txnid;
        $url = "http://sandbox.aamarpay.com/api/v1/trxcheck/request.php?request_id=$request_id&store_id=aamarpaytest&signature_key=dbb74894e82415a2f7ff0ec3a97e4183&type=json";

        $response = $this->makeAamarpayRequest($url, []);
        if ($response && $response->status == "success") {
            // Handle successful transaction
            return redirect()->to('/')->with('success', 'Payment successful!');
        }

        return redirect()->back()->with('error', 'Payment verification failed.');
    }

    public function fail()
    {
        return redirect()->to('/')->with('error', 'Payment failed. Please try again.');
    }

    public function cancel()
    {
        return redirect()->to('/')->with('info', 'Payment canceled.');
    }
}
