<!-- -->
@extends('templateDefault')

@section('content')

<script>
	// Do sync and AJAX here.... TODO
	$('document').ready(function() {
		Serve.syncAction = '/serve/' + {{ $screen->id or '1' }};
		Serve.syncToken = '{{ csrf_token() }}';
		Serve.syncScreen = {{ $screen->id or '1' }};
		Serve.syncInterval = 20000;
		Serve.init();
	});
</script>

<div id="plus_container">

	<div id="header"><h1></h1></div>
  <div class="row1">
    	<div class="quad"><img id="page_image" src="" title="" alt=""/></div>
	    <div class="quad" id="page_content">
	    	<p></p>
			</div>
	</div>

</div>

<div id="footer"></div>

@endsection
