@extends('master')

@section('content')

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Dashboard</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">my account</li>
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
					<div class="media" style="margin-bottom: 50px;">
						<div class="media-body">
							<h2 class="media-heading">Welcome Adam Smith</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, iure, est. Sit mollitia est maxime! Eos
								cupiditate tempore, tempora omnis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, nihil. </p>
						</div>
					</div>
					<div class="media">
            			<div class="pull-left text-center" href="#!">
              				<img class="media-object user-img" src="{{ asset('frontend/images/avater.jpg') }}" alt="Image">
              				<a href="#x" class="btn btn-transparent mt-20">Change Image</a>
            			</div>
            			<div class="media-body">
              				<ul class="user-profile-list">
                				<li style="margin-bottom: 20px; margin-left: 30px;"><span style="font-weight: 700;">Full Name:</span> {{ Auth::user()->name }}</li>
                				<li style="margin-bottom: 20px; margin-left: 30px;"><span style="font-weight: 700;">Phone:</span> {{ Auth::user()->phone }}</li>
                				<li style="margin-bottom: 20px; margin-left: 30px;"><span style="font-weight: 700;">Email:</span> {{ Auth::user()->email }}</li>
                				<li style="margin-bottom: 20px; margin-left: 30px;"><span style="font-weight: 700;">Address:</span> {{ Auth::user()->address }}</li>
              				</ul>
            			</div>
          			</div>
				</div>
			</div>
		</div>
	</div>
</section>


@endsection