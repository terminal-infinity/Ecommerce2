@extends('master')

@section('content')

<section class="single-product">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<ol class="breadcrumb">
					<li><a href="{{ route('home.index') }}">Home</a></li>
					<li><a href="{{ route('home.shop') }}">Shop</a></li>
					<li class="active">Single Product</li>
				</ol>
			</div>
		</div>
		<div class="row mt-20">
			<div class="col-md-5">
				<div class="single-product-slider">
					<div id='carousel-custom' class='carousel slide' data-ride='carousel'>
						<div class='carousel-outer'>
							<!-- me art lab slider -->
							<div class='carousel-inner '>
								<div class='item active'>
									<img src='/upload/product/{{$product->image}}' alt='' data-zoom-image="/upload/product/{{$product->image}}" />
								</div>
								@foreach ($images as $img)
								<div class='item'>
									<img src='/upload/product/{{$img->image}}' alt='' data-zoom-image="/upload/product/{{$img->image}}" />
								</div>
								@endforeach
							</div>
							
							<!-- sag sol -->
							<a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
								<i class="tf-ion-ios-arrow-left"></i>
							</a>
							<a class='right carousel-control' href='#carousel-custom' data-slide='next'>
								<i class="tf-ion-ios-arrow-right"></i>
							</a>
						</div>
						
						<!-- thumb -->
						<ol class='carousel-indicators mCustomScrollbar meartlab'>
							<li data-target='#carousel-custom' data-slide-to='0' class='active'>
								<img src='/upload/product/{{$product->image}}' alt='' />
							</li>
							@foreach ($images as $img)
							<li data-target='#carousel-custom' data-slide-to='1'>
								<img src='/upload/product/{{$img->image}}' alt='' />
							</li>
							@endforeach
						</ol>
					</div>
				</div>
			</div>
			<div class="col-md-7">
				<div class="single-product-details">
					<h2>{{ $product->title }}</h2>
                        @if($product->compare_price)
    						<p class="product-price" style="display: inline; color: black; font-size: large;">
        						${{ $product->compare_price }}
    						</p>
    						<p class="product-price" style="display: inline; text-decoration: line-through; color: black; font-size: medium; margin-left: 8px;">
        						${{ $product->price }}
    						</p>
						@else
    						<p class="product-price" style="display: inline; color: black; font-size: large;">
        						${{ $product->price }}
    						</p>
						@endif

					
					<p class="product-description mt-20">{!! $product->short_desc !!}</p>
                    <div class="product-size">
						<span>Colour:</span>
						<select class="form-control" name="color">
                        @foreach(explode(', ', $product->color) as $color)
                            <option value="{{ $color }}">{{ $color }}</option>
                        @endforeach
						</select>
					</div>
					<div class="product-size">
						<span>Size:</span>
						<select class="form-control" name="size">
                        @foreach(explode(', ', $product->size) as $size)
                            <option value="{{ $size }}">{{ $size }}</option>
                        @endforeach
						</select>
					</div>
                    <div class="product-category">
						<span>Quantity:</span>
						<ul>
							<li><a href="product-single.html">{{ $product->stock }}</a></li>
						</ul>
					</div>
					<div class="product-category">
						<span>Material:</span>
						<ul>
							<li><a href="product-single.html">{{ $product->material }}</a></li>
						</ul>
					</div>
					<a href="{{ route('home.addcart',$product->id) }}" class="btn btn-main mt-20">Add To Cart</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="tabCommon mt-20">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#details" aria-expanded="true">Details</a></li>
						<li class=""><a data-toggle="tab" href="#reviews" aria-expanded="false">Additional Information</a></li>
					</ul>
					<div class="tab-content patternbg">
						<div id="details" class="tab-pane fade active in">
							<h4>Product Description</h4>
							<p>{!! $product->description !!}</p>
						</div>
						<div id="reviews" class="tab-pane fade">
                        <p>{!! $product->add_info !!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="products related-products section">
	<div class="container">
		<div class="row">
			<div class="title text-center">
				<h2>Related Products</h2>
			</div>
		</div>
		<div class="row">
			@foreach ($related_product as $product)
			<div class="col-md-3">
				<div class="product-item">
					<div class="product-thumb">
						@if($product->sale == 1)
    						<span class="bage">Sale</span>
						@endif
						<img class="img-responsive" src="{{ asset('/upload/product/'.$product->image) }}" alt="product-img" />
						<div class="preview-meta">
							<ul>
								<li>
									<span  data-toggle="modal" data-target="#product-modal">
										<i class="tf-ion-ios-search"></i>
									</span>
								</li>
								<li>
			                        <a href="#" ><i class="tf-ion-ios-heart"></i></a>
								</li>
								<li>
									<a href="#!"><i class="tf-ion-android-cart"></i></a>
								</li>
							</ul>
                      	</div>
					</div>
					<div class="product-content">
						<h4><a href="{{ route('home.product_details', $product->id) }}">{{ $product->title }}</a></h4>
						@if($product->compare_price)
    						<p class="price" style="display: inline; color: black; font-size: large;">
        						${{ $product->compare_price }}
    						</p>
    						<p class="price" style="display: inline; text-decoration: line-through; color: black; font-size: medium; margin-left: 8px;">
        						${{ $product->price }}
    						</p>
						@else
    						<p class="price" style="display: inline; color: black; font-size: large;">
        						${{ $product->price }}
    						</p>
						@endif
					</div>
				</div>
			</div>
			@endforeach
			
			
		</div>
	</div>
</section>

@endsection