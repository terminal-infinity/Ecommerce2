@extends('master')

@section('content')
<style>
   .preference {
  display: flex;
  justify-content: space-between;
  width: 50%;
  margin: 0.5rem;
   }
</style>
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Checkout</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">checkout</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="page-wrapper">
   <div class="checkout shopping">
      <div class="container">
         <div class="row">
         <div class="col-md-8">
               <div class="block billing-details">
                  <h4 class="widget-title">Billing Details</h4>
                  <form class="checkout-form" method="POST" action="{{ route('home.confirm_order') }}">
                     @csrf
                     <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input 
                           type="text" 
                           class="form-control" 
                           id="c_name" 
                           name="c_name" 
                           value="{{ Auth::user()->name }}" 
                           required>
                     </div>
                     <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input 
                           type="text" 
                           class="form-control" 
                           id="c_phone" 
                           name="c_phone" 
                           value="{{ Auth::user()->phone }}" 
                           required>
                     </div>
                     <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                           type="text" 
                           class="form-control" 
                           id="c_email" 
                           name="c_email" 
                           value="{{ Auth::user()->email }}" 
                           required>
                     </div>
                     <div class="form-group">
                        <label for="full_name">City</label>
                        <input 
                           type="text" 
                           class="form-control" 
                           id="c_city" 
                           name="c_city" 
                           required>
                     </div>
                     <div class="form-group">
                        <label for="phone">Address</label>
                        <input 
                           type="text" 
                           class="form-control" 
                           id="c_address" 
                           name="c_address" 
                           required>
                     </div>
                     <div class="form-group">
                        <label for="email">Zip Code</label>
                        <input 
                           type="text" 
                           class="form-control" 
                           id="c_zipcode" 
                           name="c_zipcode" 
                           required>
                     </div>
                     <div class="form-group">
                        <label for="user_address">Country</label>
                        <input 
                           type="text" 
                           class="form-control" 
                           id="c_country" 
                           name="c_country"  
                           required>
                     </div>

                     <br>
                     <h4 class="widget-title">Payment Method</h4>
                        
                     <div class="preference">
                        <label for="payment_type">Cash On Delivary</label>
                        <input type="checkbox" name="payment_type" value="Hand cash" />
                        <label for="payment_type">Bkash/Rocket/Nagad </label>
                        <input type="checkbox" name="payment_type" value="Aamarpay" />
                     </div>

                     <button type="submit" class="btn btn-main mt-20">Place Order</button>
                  </form>
               </div>
            </div>
            
            <div class="col-md-4">
               <div class="product-checkout-details">
                  <div class="block">
                     <h4 class="widget-title">Order Summary</h4>
                     <?php
                        $value=0;
                     ?>
                    @foreach ($cart as $cart)
                     <div class="media product-card">
                        <a class="pull-left" href="product-single.html">
                           <img class="media-object" src="/upload/product/{{$cart->product->image}}" alt="Image" />
                        </a>
                        <div class="media-body">
                           <h4 class="media-heading"><a href="product-single.html">{{$cart->product->title}}</a></h4>
                           <p class="price">{{$cart->product->price}} BDT</p>
                           <span class="remove" >Remove</span>
                        </div>
                     </div>
                     <?php
                    $value=$value + $cart->product->price;
                    ?>
                    @endforeach
                     <div class="discount-code">
                        <p>Have a discount ? <a data-toggle="modal" data-target="#coupon-modal" href="#!">enter it here</a></p>
                     </div>
                     <ul class="summary-prices">
                        <li>
                           <span>Subtotal:</span>
                           <span class="price">{{$value}} BDT</span>
                        </li>
                        <li>
                           <span>Shipping:</span>
                           <span>Free</span>
                        </li>
                     </ul>
                     <div class="summary-total">
                        <span>Total</span>
                        <span>{{$value}} BDT</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


@endsection