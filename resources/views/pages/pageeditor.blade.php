@extends('backend')

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
	<div id="identity">
		<div class="pagecontainer">
			@include('templates/templateStructure')
		</div>
		<div class="pagecontainer">
			<ul class="theme_select">
				{{-- Add each template thumbnail to the DOM --}}
				@foreach($templates as $template)
					@if ($template == $activeTemplate)
						<li data-btnTemplate="true" data-template="{{$template->class_name}}" data-templateid="{{$template->id}}" class="active"> <a href="#"><img src="{{$template->thumbnail_path}}" alt="" title="{{$template->name}}" /></a></li>
					@else
						<li data-btnTemplate="true" data-template="{{$template->class_name}}" data-templateid="{{$template->id}}"> <a href="#"><img src="{{$template->thumbnail_path}}" alt="" title="{{$template->name}}" /></a></li>
					@endif
				@endforeach
			</ul>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div>

<div id="right">

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
			<!-- ADDED class=landscape as backend for SCSS targeting:: This will enable active button formatting -->
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

			<input type="hidden" name="txtTemplate" value="{{$activeTemplate->id}}"/>

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
