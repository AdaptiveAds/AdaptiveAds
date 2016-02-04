@extends('default')

@section('content')

<script>
	// Do sync and AJAX here.... TODO
	$('document').ready(function() {
		PageEditor.init();
	});
</script>

<h3>Page Editor</h3>
<h3 name="hedTitle">Title: {{ $pageData->heading or 'New Page'}}</h3>

<div id="left" class="landscape theme_oneImages">
	<div class="pagecontainer">
		@include('templates/templateStructure')
	</div>
	<div class="pagecontainer">
		<ul class="theme_select">
			<li class="select_oneImages"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
			<li class="select_twoImages"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
			<li class="select_oneVideo"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
			<li class="select_twobytwo"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
			<li class="select_twobytwoReverse"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
			<li class="select_fourbyfour"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
			<li class="select_fourbyfourReverse"><a href="#"><img src="/images/logo.png" alt="" title="" /></a></li>
		</ul>
		<div class="clear"></div>
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
				<label>Image 1:</label>
				<input type="file" name="filPageImage_1" accept="image/*"/><br>
			</li>
			<li><textarea title="content" type="text" name="txtMeta_1" placeholder="Example: Rabit on Chair...">{{ $pageData->image_meta_1 or '' }}</textarea></li>
			<li>
				<label>Image 2:</label>
				<input type="file" name="filPageImage_2" accept="image/*"/><br>
			</li>
			<li><textarea title="content" type="text" name="txtMeta_2" placeholder="Example: Dog playing violin...">{{ $pageData->image_meta_2 or '' }}</textarea></li>
			<li>
				<label>Video 1:</label>
				<input type="file" name="filPageVideo_1" accept="video/*"/><br>
			</li>
			<li><textarea title="content" type="text" name="txtVideoMeta_1" placeholder="Example: Rabit and Dog playing music...">{{ $pageData->video_meta_1 or '' }}</textarea></li>
			<li>
				<label>Video 2:</label>
				<input type="file" name="filPageVideo_2" accept="video/*"/><br>
			</li>
			<li><textarea title="content" type="text" name="txtVideoMeta_2" placeholder="Example: Rabit and Dog playing music...">{{ $pageData->video_meta_2 or '' }}</textarea></li>
			<li>
				<label>Content 1:</label>
				<textarea title="content" type="text" name="txtPageContent_1" placeholder="Enter Content...">{{ $pageData->content_1 or '' }}
				</textarea>
			</li>
			<li>
				<label>Content 2:</label>
				<textarea title="content" type="text" name="txtPageContent_2" placeholder="Enter Content...">{{ $pageData->content_2 or '' }}
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
