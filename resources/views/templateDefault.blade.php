<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>"{{ $pageName }}"</title>
	<link rel="stylesheet" 	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" 	href="{{ URL::asset('css/template.css') }}" type="text/css">
</head>

<body id="{{ $pageName }}">
<div id="wrapper">

	<div id="content">
    	@yield('content')
    	<div class="clear"></div>
	    <!-- close content -->
  	</div>
</body>
</html>
