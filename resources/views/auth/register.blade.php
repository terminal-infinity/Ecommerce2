<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>Aviato | E-commerce</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Constra HTML Template v1.0">
  
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/favicon.png') }}" />
  
  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="{{ asset('frontend/plugins/themefisher-font/style.css') }}">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap/css/bootstrap.min.css') }}">
  
  <!-- Animate css -->
  <link rel="stylesheet" href="{{ asset('frontend/plugins/animate/animate.css') }}">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick-theme.css') }}">
  
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

</head>

<body id="body">

<section class="signin-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo" href="index.html">
            <img src="{{ asset('frontend/images/logo.png') }}" alt="">
          </a>
          <h2 class="text-center">Welcome Back</h2>
          <form class="text-left clearfix" action="{{ route('register') }}" method="POST">
          @csrf
            <div class="form-group">
              <input type="text" class="form-control" name="name" id="name" placeholder="Name">
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="form-group">
            <input type="email" class="form-control" name="email" id="email" placeholder="Eamil">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="form-group">
            <input type="password" class="form-control" name="password" id="Password" placeholder="Password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="form-group">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation">
              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-main text-center" >Sign In</button>
            </div>
          </form>
          <p class="mt-20">Already hava an account ?<a href="{{ route('login') }}"> Login</a></p>
          <p><a href="forget-password.html"> Forgot your password?</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- 
    Essential Scripts
    =====================================-->
    
    <!-- Main jQuery -->
    <script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.1 -->
    <script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Bootstrap Touchpin -->
    <script src="{{ asset('frontend/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!-- Instagram Feed Js -->
    <script src="{{ asset('frontend/plugins/instafeed/instafeed.min.js') }}"></script>
    <!-- Video Lightbox Plugin -->
    <script src="{{ asset('frontend/plugins/ekko-lightbox/dist/ekko-lightbox.min.js') }}"></script>
    <!-- Count Down Js -->
    <script src="{{ asset('frontend/plugins/syo-timer/build/jquery.syotimer.min.js') }}"></script>

    <!-- slick Carousel -->
    <script src="{{ asset('frontend/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/slick/slick-animation.min.js') }}"></script>

    <!-- Google Mapl -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="{{ asset('frontend/plugins/google-map/gmap.js') }}"></script>

    <!-- Main Js File -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    


  </body>
  </html>