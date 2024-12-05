@extends('master')

@section('content')

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Shop</h1>
					<ol class="breadcrumb">
						<li><a href="{{ route('home.index') }}">Home</a></li>
						<li class="active">shop</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="products section">
	<div class="container">
		<div class="row">
		<div class="col-md-3">
    <!-- Sort By -->
    <div class="widget">
        <h4 class="widget-title">Sort By</h4>
        <select class="form-control" onchange="location = this.value;">
            <option value="{{ route('home.shop', array_merge(request()->except('sort'), ['sort' => null])) }}" {{ request('sort') == null ? 'selected' : '' }}>All</option>
            <option value="{{ route('home.shop', array_merge(request()->except('sort'), ['sort' => 'sale'])) }}" {{ request('sort') == 'sale' ? 'selected' : '' }}>Sale</option>
            <option value="{{ route('home.shop', array_merge(request()->except('sort'), ['sort' => 'hot'])) }}" {{ request('sort') == 'hot' ? 'selected' : '' }}>Hot Product</option>
            <option value="{{ route('home.shop', array_merge(request()->except('sort'), ['sort' => 'trendy'])) }}" {{ request('sort') == 'trendy' ? 'selected' : '' }}>Trendy Product</option>
        </select>
    </div>

    <!-- Price -->
    <div class="widget">
        <h4 class="widget-title">Price</h4>
        <select class="form-control" onchange="location = this.value;">
            <option value="{{ route('home.shop', array_merge(request()->except('sort'), ['sort' => null])) }}" {{ request('sort') == null ? 'selected' : '' }}>Default</option>
            <option value="{{ route('home.shop', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Low to High</option>
            <option value="{{ route('home.shop', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>High to Low</option>
        </select>
    </div>

    <!-- Brand -->
    <div class="widget">
        <h4 class="widget-title">Brand</h4>
        <select class="form-control" onchange="location = this.value;">
            <option value="{{ route('home.shop', request()->except('brand')) }}">All Brands</option>
            @foreach ($brand as $brands)
                <option value="{{ route('home.shop', array_merge(request()->except('brand'), ['brand' => $brands->id])) }}" {{ request('brand') == $brands->id ? 'selected' : '' }}>
                    {{ $brands->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Categories -->
    <div class="widget product-category">
        <h4 class="widget-title">Categories</h4>
        <div class="panel-group commonAccordion" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach($category as $categoryItem)
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading{{ $categoryItem->id }}">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $categoryItem->id }}" aria-expanded="false" aria-controls="collapse{{ $categoryItem->id }}">
                                {{ $categoryItem->name }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse{{ $categoryItem->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $categoryItem->id }}">
                        <div class="panel-body">
                            @if($categoryItem->subcategories->isNotEmpty())
                                <ul>
                                    @foreach($categoryItem->subcategories as $subcategory)
                                        <li><a href="{{ route('home.shop', array_merge(request()->except('subcategory'), ['subcategory' => $subcategory->id])) }}">{{ $subcategory->name }}</a></li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No subcategories available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

			<div class="col-md-9">
				<div class="row">
				@foreach ($product as $products)
				<div class="col-md-4">
				<div class="product-item">
					<div class="product-thumb">
						@if($products->sale == 1)
    						<span class="bage">Sale</span>
						@endif
						<img class="img-responsive" src="{{ asset('/upload/product/'.$products->image) }}" alt="product-img" />
						<div class="preview-meta">
							<ul>
								<li>
									<span  data-toggle="modal" data-target="#product-modal">
										<i class="tf-ion-ios-search-strong"></i>
									</span>
								</li>
								<li>
			                        <a href="#!" ><i class="tf-ion-ios-heart"></i></a>
								</li>
								<li>
									<a href="{{ route('home.addcart',$products->id) }}"><i class="tf-ion-android-cart"></i></a>
								</li>
							</ul>
                      	</div>
					</div>
					<div class="product-content">
						<h4><a href="{{ route('home.product_details', $products->id) }}" style="font-weight: 500;">{{ $products->title }}</a></h4>
						@if($products->compare_price)
    						<p class="price" style="display: inline; color: black; font-size: large;">
        						${{ $products->compare_price }}
    						</p>
    						<p class="price" style="display: inline; text-decoration: line-through; color: black; font-size: medium; margin-left: 8px;">
        						${{ $products->price }}
    						</p>
						@else
    						<p class="price" style="display: inline; color: black; font-size: large;">
        						${{ $products->price }}
    						</p>
						@endif
					</div>
				</div>
			</div>
			@endforeach	

		
		<!-- Modal -->
		<div class="modal product-modal fade" id="product-modal">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i class="tf-ion-close"></i>
			</button>
		  	<div class="modal-dialog " role="document">
		    	<div class="modal-content">
			      	<div class="modal-body">
			        	<div class="row">
			        		<div class="col-md-8 col-sm-6 col-xs-12">
			        			<div class="modal-image">
				        			<img class="img-responsive" src="images/shop/products/modal-product.jpg" alt="product-img" />
			        			</div>
			        		</div>
			        		<div class="col-md-4 col-sm-6 col-xs-12">
			        			<div class="product-short-details">
			        				<h2 class="product-title">GM Pendant, Basalt Grey</h2>
			        				<p class="product-price">$200</p>
			        				<p class="product-short-description">
			        					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem iusto nihil cum. Illo laborum numquam rem aut officia dicta cumque.
			        				</p>
			        				<a href="cart.html" class="btn btn-main">Add To Cart</a>
			        				<a href="product-single.html" class="btn btn-transparent">View Product Details</a>
			        			</div>
			        		</div>
			        	</div>
			        </div>
		    	</div>
		  	</div>
		</div><!-- /.modal -->

				</div>				
			</div>
		
		</div>
	</div>
	<!-- Pagination -->
	<div class="flex-c-m flex-w w-full p-t-38">
            <div class="your-paginate mt-4">
                {{ $product->links() }}
            </div>
        </div>
</section>

@endsection