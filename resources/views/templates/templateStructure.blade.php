@if(isset($serve))

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

@endif

<div id="serve_container" class="template1">
	<div id="header"><h1 name="pageName">{{ $pageData->heading or 'New Page'}}</h1></div>
  <div class="row">
    	<div id="serve_image">
				@if (isset($pageData->image_path) AND $pageData->image_path != '')
						<img src="/advert_images/{{ $pageData->image_path }}" title="" alt=""/>
				@else
						<img src="/images/logo.png" title="" alt=""/>
				@endif
			</div>

			<div id="serve_text">
	    		<p name="pageContent">{{ $pageData->content or '' }}</p>
			</div>
	</div>
  <div class="clear"></div>
</div>
<div id="footer">
	<ul>
			<li>Term time hours: 8.30am – midnight</li>
			<li>Term time weekends – Sat & Sun,  11am – 6pm</li>
	</ul>
	<div class="clear"></div>
</div>
