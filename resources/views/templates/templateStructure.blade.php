<div id="serve_container">
	<div id="header"><h1></h1></div>
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
<div id="footer"></div>
