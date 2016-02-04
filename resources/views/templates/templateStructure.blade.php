<div id="plus_container" class="theme_fourbyfour">

	<div id="header"><h1 name="pageName">{{ $pageData->heading or 'Heading' }}</h1></div>
  <div class="row">
    	<div class="quad">
				@if (isset($pageData->image_path_1) AND $pageData->image_path_1 != '')
						<img src="/advert_images/{{ $pageData->image_path_1 }}" title="" alt=""/>
				@else
						<img src="/images/logo.png" title="" alt=""/>
				@endif
			</div>
	    <div class="quad" id="page_content">
	    	<p name="pageContent_1">{{ $pageData->content_1 or '' }}</p>
			</div>
	</div>

	<div class="row">
    	<div class="quad">
				@if (isset($pageData->image_path_2) AND $pageData->image_path_2 != '')
						<img src="/advert_images/{{ $pageData->image_path_2 }}" title="" alt=""/>
				@else
						<img src="/images/logo.png" title="" alt=""/>
				@endif
			</div>
	    <div class="quad">
	    	<p name="pageContent_2">{{ $pageData->content_2 or '' }}</p>
			</div>
	</div>
  <div class="clear"></div>
</div>

<div id="footer"></div>
