<!DOCTYPE html>
<html lang="en">
@include('frontend.partials.head')
<body id="body">

<!-- Navbar Start -->
@include('frontend.partials.navbar')
<!-- Navbar End -->


@yield('content')

<!-- Footer Start -->
@include('frontend.partials.footer')
<!-- Footer End -->


@include('frontend.partials.scripts')

</body>
</html>
