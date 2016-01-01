@extends('default')

@section('content')

<h3>Page Editor</h3>
<h3>Title: {{ $pageData->page_data_name or 'New Page'}}</h3>

<div id="left" class="landscape">
	<div class="pagecontainer">
		<ul>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
	<div class="pagecontainer">
		<ul>
			<li><a href="#">Theme</a></li>
			<li><a href="#">Theme</a></li>
			<li><a href="#">Theme</a></li>
			<li><a href="#">Theme</a></li>
			<li><a href="#">Theme</a></li>
		</ul>
	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ??
	<form name="pageEditor" action="index_submit" method="get" accept-charset="utf-8"> -->
		<ul>
		@if (isset($pageData))
			{!! Form::open(['route' => ['dashboard.advert.{adID}.page.update', $page->id], 'method' => 'PUT']) !!}
		@else
			{!! Form::open(['route' => ['dashboard.advert.{adID}.page.store',  $page->advert_id], 'method' => 'POST']) !!}
		@endif
			<li id="orientation">
				<button class="btn-orientationHor" type="button">Landscape</button>
				<button class="btn-orientationVert" type="button">Portrait</button>
				<div class="clear"></div>
			</li>
			<li>
				<label>Title</label>
				<input type="text" placeholder="Page Name...." name="pageName"/>
			</li>
			<li>
				<label>Image:</label>
				<input type="text" name="pageImage" placeholder="Image path..."><br>
			</li>
			<li><textarea title="content" type="text" name="imageMeta" placeholder="Image Meta..." required></textarea></li>
			<li>
				<label>Video:</label>
				<input type="text" name="pageVideo" placeholder="Video path..."><br>
			</li>
			<li><textarea title="content" type="text" name="videoMeta" placeholder="Video Meta..." required></textarea></li>
			<li>
				<label>Page Index: </label>
				<input type="number" name="pageIndex" value="0"/>
			</li>
			<li>
				<label>Content</label>
				<textarea title="content" type="text" name="pageContent" placeholder="Enter Content..." required></textarea>
			</li>
			<li><button type"submit" class"submit">Save</button></li>
			{!! Form::close() !!}
			{!! Form::open(['route' => ['dashboard.advert.{adID}.page.destroy', $page->id], 'method' => 'DELETE']) !!}
			<li><button type="submit" class="submit">Delete</button></li>
			{!! Form::close() !!}
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
</div>
@endsection
