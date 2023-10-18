<!DOCTYPE html>
<html lang="en-us">

<head>
	<meta charset="utf-8">
	<title>Wallet - Payday Loan Service Template</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<meta name="description" content="This is meta description">
	<meta name="author" content="Themefisher">
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
	<link rel="icon" href="images/favicon.png" type="image/x-icon">
  
  <!-- theme meta -->
  <meta name="theme-name" content="wallet" />

	<!-- # Google Fonts -->
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