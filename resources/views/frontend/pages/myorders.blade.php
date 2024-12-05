@extends('master')

@section('content')

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Dashboard</h1>
					<ol class="breadcrumb">
						<li><a href="{{ route('home.index') }}">Home</a></li>
						<li class="active">My Account</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="user-dashboard page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="list-inline dashboard-menu text-center">
					<li><a href="{{ route('home.dashboard') }}">Dashboard</a></li>
					<li><a class="active" href="{{ route('home.myorders') }}">Orders</a></li>
				</ul>
				<div class="dashboard-wrapper user-dashboard">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Order ID</th>
									<th>Date</th>
									<th>Title</th>
									<th>Image</th>
									<th>Total Price</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
                            @foreach($order as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->created_at->format('M d, Y')}}</td>
                                    <td>{{$order->product->title}}</td>
                                    <td>
                                        <img width="50" src="/upload/product/{{$order->product->image}}" alt="">
                                    </td>
                                    <td>{{$order->product->price}}</td>
                                    <td>
                                    @if ($order->status == 'in progress')
                                        <span class="label label-primary">{{$order->status}}</span>
                                    @else
                                        <span class="label label-success">{{$order->status}}</span>
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection