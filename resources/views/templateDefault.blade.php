<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Playlist: {{ $screen->playlist->name }} </title>
	<link rel="stylesheet" 	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" 	href="{{ URL::asset('css/server.css') }}" type="text/css">
	<link rel="stylesheet" 	href="{{ URL::asset('css/animate.css') }}" type="text/css">
	<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>
	<script src="{{ URL::asset('js/helpers.js') }}"></script>
	<script src="{{ URL::asset('js/modules.js') }}"></script>
	<script src="{{ URL::asset('js/pages.js') }}"></script>
</head>

<body id="">
<div id="wrapper">

	<div id="content">
    	@include('templates/templateStructure')
    	<div class="clear"></div>
	    <!-- close content -->
  </div>
</div>
</body>
</html>
