@if(isset($serve))

	<script>
		$('document').ready(function() {
			Serve.syncAction = '/serve/' + {{ $screen->id or '1' }};
			Serve.syncToken = '{{ csrf_token() }}';
			Serve.syncScreen = {{ $screen->id or '1' }};
			Serve.init();
		});
	</script>

@endif

<div id="serve_container" class="{{$activeTemplate->class_name or 'template1'}}">
	<div id="header">
		<h1 name="pageName">{{ $pageData->heading or 'New Page'}}</h1>
	</div>
  <div class="row">
    	<div id="serve_image">
          @if (isset($pageData))
	          @if (isset($pageData->image_path) AND $pageData->image_path != "")
	  						<img src="/advert_images/{{ $pageData->image_path or 'image_placeholder.png' }}" title="" alt=""/>
	  				@else
							@if (isset($pageData->video_path) AND $pageData->video_path != "")
  							<video autoplay loop>
  								<source src="/advert_videos/{{$pageData->video_path}}" type="video/mp4">
  								<source src="/advert_videos/{{$pageData->video_path}}" type="video/ogg">
  								Your browser does not support the provided codec types.
  							</video>
							@else
								<img src="/advert_images/image_placeholder.png" title="" alt=""/>
							@endif
	  				@endif
					@else
            <img src="/advert_images/image_placeholder.png" title="" alt=""/>
          @endif
			</div>

			<div id="serve_text">
	    		<p name="pageContent">{{ $pageData->content or '' }}</p>
			</div>
			<div class="clear"></div>
	</div>
  <div class="clear"></div>
</div>
{{-- Removes the footer on full screen templates image/video --}}
@if ($activeTemplate->class_name != 'template5' AND $activeTemplate->class_name != 'template2')
	@include('apis/PCNumbers/summary_footer')
@endif
