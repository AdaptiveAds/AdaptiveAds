<!-- -->
@extends('templateDefault')

@section('content')

<script>
	// Do sync and AJAX here.... TODO
	$('document').ready(function() {
		Page.serve.setup_interval();
		Page.serve.template.register_eventhandlers();
	});
</script>

<div id="ad_container">

	<div id="header">

		<h1>{{ $playlist[0]->adverts[0]->page[0]->pageData->page_data_name }}</h1>
	</div>

    <div class="row1">

    	<div class="quad">
    		<img src="" title="" alt=""/>
    	</div>

	    <div class="quad">
	    	<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
				tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean
				ultricies mi vitae est. Mauris placerat eleifend leo.
			</p>
		</div>
	</div>

	<div class="row2">

    	<div class="quad">
    		<img src="" title="" alt=""/>
    	</div>

	    <div class="quad">
	    	<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
				tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean
				ultricies mi vitae est. Mauris placerat eleifend leo.
			</p>
		</div>
	</div>


</div>

<div id="footer"></div>

@endsection
