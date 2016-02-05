<div id="plus_container" class="theme_fourbyfour">

	<div id="header"><h1 name="pageName">{{ $pageData->heading or 'Heading' }}</h1></div>
  <div class="row">
    	<div class="quad">
				@if (isset($pageData->image_path) AND $pageData->image_path != '')
						<img src="/advert_images/{{ $pageData->image_path }}" title="" alt=""/>
				@else
						<img src="/images/logo.png" title="" alt=""/>
				@endif
			</div>
	    <div class="quad" id="page_content">
	    	<p name="pageContent">{{ $pageData->content or '' }}</p>
			</div>
	</div>
  <div class="clear"></div>
</div>

<div id="footer"></div>
