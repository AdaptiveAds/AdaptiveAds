<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Playlist: {{ $playlist->name }} </title>
	<link rel="stylesheet" 	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" 	href="{{ URL::asset('css/server.css') }}" type="text/css">
	<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>
	<script src="{{ URL::asset('js/helpers.js') }}"></script>
	<script src="{{ URL::asset('js/modules.js') }}"></script>
	<script src="{{ URL::asset('js/pages.js') }}"></script>
</head>

@if (isset($advertBackground))
	@if (strlen($advertBackground->image_path) > 0)
		<body id="" style="
				background: url({{ url('advert_backgrounds/' . $advertBackground->image_path) }});
				background-size: cover;">
	@elseif (strlen($advertBackground->hex_colour) > 0)
		<body id="" style="
				background: #{{$advertBackground->hex_colour}};">
	@endif
@endif

<div id="wrapper">

	<div id="content">
    	@include('templates/templateStructure')
    	<div class="clear"></div>
	    <!-- close content -->
  </div>
</div>
</body>
</html>
