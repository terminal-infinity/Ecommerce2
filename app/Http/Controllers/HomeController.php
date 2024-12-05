<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

class HomeController extends Controller
{
    // index method
    public function Index(){
        if(Auth::id()){
            $user=Auth::user();
            $user_id=$user->id;
            $count=Cart::where('user_id',$user_id)->count();
        }
        else{
            $count='';
        }
        return view('frontend.pages.index',compact('count'));
    }

    //dashboard
    public function dashboard(){
        if(Auth::id()){
            $user=Auth::user();
            $user_id=$user->id;
            $count=Cart::where('user_id',$user_id)->count();
        }
        else{
            $count='';
        }
        return view('dashboard',compact('count'));
    }

    // Shop method
    public function shop(Request $request){
        if(Auth::id()){
            $user=Auth::user();
            $user_id=$user->id;
            $count=Cart::where('user_id',$user_id)->count();
        }
        else{
            $count='';
        }
        $query = Product::where('status', '1');
        $brand = Brand::all();
        $category = Category::where('status', '1')->with('subcategories')->get();
    
        // Apply sorting
        if ($request->sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort == 'hot') {
            $query->where('hot', '1');
        } elseif ($request->sort == 'sale') {
            $query->where('sale', '1');
        } elseif ($request->sort == 'trendy') {
            $query->where('featured', '1');
        }
    
        // Apply filters
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('subcategory') && $request->subcategory) {
            $query->where('subcategory_id', $request->subcategory);
        }
        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }
    
        // Execute the query with pagination
        $product = $query->paginate(20)->withQueryString();
    
        return view('frontend.pages.shop', compact('product', 'category', 'brand','count'));
    }
    

    // Product Details method
    public function product_details(Request $request, $id){
        if(Auth::id()){
            $user=Auth::user();
            $user_id=$user->id;
            $count=Cart::where('user_id',$user_id)->count();
        }
        else{
            $count='';
        }
        $product=Product::findOrFail($id);
        $images = ProductImage::where('product_id',$id)->get();
        $related_product = Product::where('category_id', $product->category_id)
                              ->where('id', '!=', $id)
                              ->take(8)
                              ->get();
        $brand=Brand::all();
        $colours=Color::all();
        $categories = Category::where('status', '1')->with('subcategories')->get();
        return view('frontend.pages.product_details',compact('product','categories','brand','images','related_product','count','colours'));
    }

    //Show Cart
    public function mycart(){
        if(Auth::id()){
            $user=Auth::user();
            $userid=$user->id;
            $count=Cart::where('user_id',$userid)->count();

            $cart=Cart::where('user_id',$userid)->get();
        }
        else{
            $count='';
        }
        return view('frontend.pages.mycart',compact('count','cart'));
    }

    //Add Cart
    public function add_cart(Request $request, $id){
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'You need to log in to add products to the cart.');
    }

    $product = Product::find($id);

    if (!$product) {
        return redirect()->back()->with('error', 'Product not found.');
    }

    // Check if the product is already in the cart
    $existingCart = Cart::where('user_id', $user->id)
        ->where('product_id', $id)
        ->first();

    if ($existingCart) {
        // Increment quantity if already in the cart
        $existingCart->quantity += $request->input('quantity', 1);
        $existingCart->save();

        return redirect()->back()->with('success', 'Product quantity updated in the cart.');
    }

    // Add new product to the cart
    $cart = new Cart();
    $cart->user_id = $user->id;
    $cart->product_id = $product->id;
    $cart->quantity = $request->input('quantity', 1);
    $cart->price = $product->compare_price; // Store the product's current price
    $cart->color = $request->input('color');
    $cart->size = $request->input('size');

    $cart->save();

    return redirect()->back()->with('success', 'Product added to the cart successfully.');
}




    //Remove Cart
    public function remove_cart($id){
        $data = Cart::find($id);
        
        $data->delete();

        return redirect()->back()->with('success','Product Removed To The Cart Successfully');
        
    }

    //Checkout
    public function checkout(){
        if(Auth::id()){
            $user=Auth::user();
            $userid=$user->id;
            $count=Cart::where('user_id',$userid)->count();

            $cart=Cart::where('user_id',$userid)->get();
        }
        else{
            $count='';
        }
        return view('frontend.pages.checkout',compact('count','cart'));
    }


        //Show Order
        public function myorders(){

            $user=Auth::user()->id;
            $count=Cart::where('user_id',$user)->get()->count();
    
            $order=Order::where('user_id',$user)->get();
    
        return view('frontend.pages.myorders',compact('count','order'));
        }

}
