<!DOCTYPE html>
<html lang="en-us">

<head>
	<meta charset="utf-8">
	<title>Issue Tracker</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<meta name="description" content="This is meta description">
	<meta name="author" content="Themefisher">
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
	<link rel="icon" href="images/favicon.png" type="image/x-icon">
  
  <meta name="theme-name" content="wallet" />

	@include('front.layout.style.style')
    @yield('style')
</head>

<body>
    @include('front.layout.header')
    @yield('content')


    @include('front.layout.footer')
    @include('front.layout.script.script')
    @yield('script')
</body>