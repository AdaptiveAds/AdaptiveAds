<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>AdaptiveAds</title>

	<link rel="stylesheet" 	href="{{ URL::asset('fonts/font-awesome-4.5.0/css/font-awesome.min.css') }}">

<!-- preferred plan would be to compile the css from scss prior to uploading using propos -->
	<link rel="stylesheet" 	href="{{ URL::asset('css/default.css') }}" type="text/css">

	<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>
	<script src="{{ URL::asset('js/colorpicker.js') }}"></script>
	<script src="{{ URL::asset('js/inputdelete.js') }}"></script>
	<script src="{{ URL::asset('js/mobilemenu.js') }}"></script>

@include('pages\headJavascript')
	<script src="{{ URL::asset('js/helpers.js') }}"></script>
	<script src="{{ URL::asset('js/modules.js') }}"></script>
	<script src="{{ URL::asset('js/pages.js') }}"></script>

</head>


<body class="data-swatch-theme-a font-theme-b">
<div id="wrapper">
@include('pages/header')


	<div id="content">
    @yield('content')

  <!-- close content -->
	<div class="clear"></div>
  </div>
	<footer>
		<!-- if logged in -->
		@if (Auth::guest() == false)
			&copy; <?php echo date('Y'); ?>. <a href="http://www.glos.ac.uk/" target="_window">University of Gloucestershire</a>. All Rights Reserved.
		@else
		<!-- if logged out -->
			&copy; <?php echo date('Y'); ?>. <a href="http://www.adaptiveads.uk">AdaptiveAds</a>. All Rights Reserved.
		@endif

  </footer>

<!-- close wrapper -->
<div class="clear"></div>
</div>
</body>
</html>
