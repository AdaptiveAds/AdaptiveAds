<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Playlist: {{ $playlist[0]->playlist_name }} </title>
	<link rel="stylesheet" 	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" 	href="{{ URL::asset('css/template.css') }}" type="text/css">
	<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>
	<script src="{{ URL::asset('js/pages.js') }}"></script>
</head>

<body id="">
<div id="wrapper">

	<div id="content">
    	@yield('content')
    	<div class="clear"></div>
	    <!-- close content -->
  	</div>
</body>
</html>