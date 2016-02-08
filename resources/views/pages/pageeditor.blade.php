@extends('default')

@section('content')

<script>
	// Do sync and AJAX here.... TODO
	$('document').ready(function() {
		PageEditor.init();
	});
</script>

<h3>Page Editor</h3>
<h3 name="pageName">Title: {{ $pageData->heading or 'New Page'}}</h3>


<div id="left" class="landscape">
	<div id="identity" class="theme1">
		<div class="pagecontainer">
			@include('templates/templateStructure')
		</div>
		<div class="pagecontainer">
			<ul class="theme_select">
				<li class="theme1 active"> <a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
				<li class="theme2"> <a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
				<li class="theme3"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
				<li class="theme4"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
				<li class="theme5"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
				<li class="theme6"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>

				<script>
					$( "li.theme1" ).click(function() {
						$( "li" ).removeClass("active");
						$( this ).addClass( "active" );
						$( "#identity" ).removeClass();
						$( "#identity" ).addClass( "theme1" );
					});

					$( "li.theme2" ).click(function() {
						$( "li" ).removeClass("active");
						$( this ).addClass( "active" );
						$( "#identity" ).removeClass();
						$( "#identity" ).addClass( "theme2" );
					});

					$( "li.theme3" ).click(function() {
						$( "li" ).removeClass("active");
						$( this ).addClass( "active" );
						$( "#identity" ).removeClass();
						$( "#identity" ).addClass( "theme3" );
					});

					$( "li.theme4" ).click(function() {
						$( "li" ).removeClass("active");
						$( this ).addClass( "active" );
						$( "#identity" ).removeClass();
						$( "#identity" ).addClass( "theme4" );
					});

					$( "li.theme5" ).click(function() {
						$( "li" ).removeClass("active");
						$( this ).addClass( "active" );
						$( "#identity" ).removeClass();
						$( "#identity" ).addClass( "theme5" );
					});

					$( "li.theme6" ).click(function() {
						$( "li" ).removeClass("active");
						$( this ).addClass( "active" );
						$( "#identity" ).removeClass();
						$( "#identity" ).addClass( "theme6" );
					});
				</script>

			</ul>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div>

<div id="right">

	<!-- PHP Driven self updating ??
	<form name="pageEditor" action="index_submit" method="get" accept-charset="utf-8"> -->
		<ul>
		@if (isset($pageData))
			{!! Form::open(['route' => ['dashboard.advert.{adID}.page.update', $page->advert_id, $page->id],
																	'method' => 'PUT',
																	'files' => true]) !!}
		@else
			{!! Form::open(['route' => ['dashboard.advert.{adID}.page.store',  $page->advert_id],
			 														'method' => 'POST',
																	'files' => true]) !!}
		@endif
			<!-- ADDED class=landscape as default for SCSS targeting:: This will enable active button formatting -->
			<li id="orientation">
				<button class="btn-orientationHor active" type="button">Landscape</button>
				<button class="btn-orientationVert" type="button">Portrait</button>
				<div class="clear"></div>
			</li>
			<li>
				<label>Title</label>
				<input type="text" placeholder="Page Name...." name="txtPageName" value="{{ $pageData->heading or '' }}" required>
			</li>
			<li>
				<label>Image:</label>
				<input type="file" name="filPageImage" accept="image/*"/><br>
			</li>
			<li><textarea title="content" type="text" name="txtMeta" placeholder="Example: Rabit on Chair...">{{ $pageData->image_meta or '' }}</textarea></li>
			<li>
				<label>Video:</label>
				<input type="file" name="filPageVideo" accept="video/*"/><br>
			</li>
			<li><textarea title="content" type="text" name="txtVideoMeta" placeholder="Example: Rabit and Dog playing music...">{{ $pageData->video_meta or '' }}</textarea></li>
			<li>
				<label>Content:</label>
				<textarea title="content" type="text" name="txtPageContent" placeholder="Enter Content...">{{ $pageData->content or '' }}
				</textarea>
			</li>
			<li><button type="submit" class="submit" name="btnSavePage">Save</button></li>
			{!! Form::close() !!}
			{!! Form::open(['route' => ['dashboard.advert.{adID}.page.destroy', $page->advert_id, $page->id], 'method' => 'DELETE']) !!}
			<li><button type="submit" class="submit" name="btnDeletePage">Delete</button></li>
			{!! Form::close() !!}
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
</div>
@endsection
