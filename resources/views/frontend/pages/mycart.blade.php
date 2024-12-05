@extends('master')

@section('content')

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Cart</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">cart</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>



<div class="page-wrapper">
  <div class="cart shopping">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="block">
            <div class="product-list">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="">Item Name</th>
                      <th class="">Item Price</th>
                      <th class="">Item Color</th>
                      <th class="">Item Size</th>
                      <th class="">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
              
                    $value=0;
              
                    ?>
                    @foreach ($cart as $cart)
                    <tr class="">
                      <td class="">
                        <div class="product-info">
                          <img width="80" src="/upload/product/{{$cart->product->image}}" alt="" />
                          <a href="{{ route('home.product_details', $cart->id) }}">{{$cart->product->title}}</a>
                        </div>
                      </td>
                      <td class="">${{$cart->product->price}}</td>
                      <td class="">{{$cart->product->color}}</td>
                      <td class="">{{$cart->product->size}}</td>
                      <td class="">
                        <a class="product-remove" href="{{ route('home.remove_cart',$cart->id) }}">Remove</a>
                      </td>
                    </tr>

                    <?php
              
                    $value=$value + $cart->product->price;
              
                    ?>
                    @endforeach
                  </tbody>
                </table>
                <br>
                <div class="m-4 p-2">
                  <h3>Total Value of Cart is: ${{$value}}</h3>
                </div>
                <br>
                <div class="m-4">
                  <a href="{{ url('/checkout') }}" class="btn btn-main pull-right">Checkout</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection