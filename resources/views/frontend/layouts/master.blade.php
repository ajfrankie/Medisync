<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @include('frontend.layouts.head-css')
</head>

@section('body')
    <body data-sidebar="dark" data-layout-mode="light">
@show
    
        <!-- Navbar -->
        @include('frontend.layouts.nav')

        <!-- Page-content -->
        @yield('content')

        <!-- Footer -->
        @include('frontend.layouts.footer')

    <!-- JAVASCRIPT -->
    @include('frontend.layouts.vendor-scripts')
</body>

</html>
