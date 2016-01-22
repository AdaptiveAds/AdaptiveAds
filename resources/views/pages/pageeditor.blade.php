@extends('default')

@section('content')

<h3>Page Editor</h3>
<h3>Title: {{ $pageData->heading or 'New Page'}}</h3>

<div id="left" class="landscape theme_oneImages">
	<div class="pagecontainer">
		@include('templateStructure')
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

	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ??
	<form name="pageEditor" action="index_submit" method="get" accept-charset="utf-8"> -->
		<ul>
		@if (isset($pageData))
			{!! Form::open(['route' => ['dashboard.advert.{adID}.page.update', $page->advert_id, $page->id], 'method' => 'PUT']) !!}
		@else
			{!! Form::open(['route' => ['dashboard.advert.{adID}.page.store',  $page->advert_id], 'method' => 'POST']) !!}
		@endif
			<!-- ADDED class=landscape as default for SCSS targeting:: This will enable active button formatting -->
			<li id="orientation">
				<button class="btn-orientationHor active" type="button">Landscape</button>
				<button class="btn-orientationVert" type="button">Portrait</button>
				<div class="clear"></div>
			</li>
			<li>
				<label>Title</label>
				<input type="text" placeholder="Page Name...." name="txtPageName" value="{{ $pageData->heading or '' }}"/>
			</li>
			<li>
				<label>Image 1:</label>
				<input type="text" name="txtPageImage" placeholder="Image path..." value="{{ $pageData->image_path or '' }}"><br>
			</li>
			<li><textarea title="content" type="text" name="imageMeta" placeholder="Example: Rabit on Chair..." required>{{ $pageData->image_meta or '' }}</textarea></li>
			<li>
				<label>Image 2:</label>
				<input type="text" name="pageImage" placeholder="Image path..." value="{{ $pageData->page_image or '' }}"><br>
			</li>
			<li><textarea title="content" type="text" name="imageMeta" placeholder="Example: Dog playing violin..." required></textarea></li>
			<li>
				<label>Video:</label>
				<input type="text" name="txtPageVideo" placeholder="Video path..." value="{{ $pageData->video_path or '' }}"><br>
			</li>
			<li><textarea title="content" type="text" name="txtVideoMeta" placeholder="Example: Rabit and Dog playing music..." required>{{ $pageData->video_meta or '' }}</textarea></li>
			<li>
				<label>Page Index: </label>
				<input type="number" name="NumPageIndex" value="{{ $page->page_index or 0}}"/>
			</li>
			<li>
				<label>Content 1:</label>
				<textarea title="content" type="text" name="pageContent" placeholder="Enter Content..." required>{{ $pageData->content_1 or '' }}
				</textarea>
			</li>
			<li>
				<label>Content 2:</label>
				<textarea title="content" type="text" name="pageContent" placeholder="Enter Content..." required>{{ $pageData->content_2 or '' }}
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
