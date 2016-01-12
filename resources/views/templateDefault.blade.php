<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Playlist: {{ $playlist->playlist_name }}</title>
	<link rel="stylesheet" 	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" 	href="{{ URL::asset('css/template.css') }}" type="text/css">
</head>

<body id="">
<div id="wrapper">

	<div id="content">
    	@include('templateStructure')
    	<div class="clear"></div>
	    <!-- close content -->
  	</div>
</body>
</html>
