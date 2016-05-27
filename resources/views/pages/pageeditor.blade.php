@extends('backend')

@section('content')

<script>
	// Do sync and AJAX here.... TODO
	$('document').ready(function() {
		PageEditor.init();
		PageEditor.updateTransitions('{{$page->transition or "noneIn"}}');
	});
</script>

<h3>Page Editor</h3>
<!--<h3 name="pageName">Title: {{ $pageData->heading or 'New Page'}}</h3>-->
@if (Session::has('message'))
	<h5>{{Session::pull('message')}}</h5>
@else
	<h5>Ready to design</h5>
@endif

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
				<label><b>Title:</b></label>
				<input type="text" placeholder="Page Name...." name="txtPageName" value="{{ $pageData->heading or '' }}" required>
			</li>
			<li>
				<label><b>Content:</b></label>
				<textarea title="content" type="text" name="txtPageContent" placeholder="Enter Content...">{{ $pageData->content or '' }}</textarea>
			</li>
			<li>
				<label><b>Image:</b></label>
				<input type="file" name="filPageImage" accept="image/*"/><br>
			</li>
			<li>
				<label><b>Video:</b></label>
				<input type="file" name="filPageVideo" accept="video/*"/><br>
			</li>
			<li>
				<label><b>TransitionL</b></label>
				@include('objects/dropdown_transitions')
				<label><b>Direction:</b></label>
				@include('objects/dropdown_transition_direction')
			</li>

			<input type="hidden" name="txtTemplate" value="{{$activeTemplate->id}}"/>

			<li><button type="submit" class="submit" name="btnSavePage">Save</button></li>
			{!! Form::close() !!}
			{!! Form::open(['route' => ['dashboard.advert.{adID}.page.destroy', $page->advert_id, $page->id], 'method' => 'DELETE']) !!}
			<li><button type="submit" class="submit" name="btnDeletePage">Delete</button></li>
			{!! Form::close() !!}

      <li>
        <a href="{{ URL::route('dashboard.advert.{adID}.page.create', $page->advert_id) }}">
          <button type="submit" name="btnNext">Next</button>
        </a>
      </li>

      <li>
        <a href="{{ URL::route('dashboard.advert.edit', $page->advert_id) }}">
          <button type="submit" name="btnClose">Close</button>
        </a>
      </li>

			@if (isset($pageData->image_path) AND $pageData->image_path != "")
				{!! Form::open(['route' => ['dashboard.advert.page.removeMedia', $page->advert_id, $page->id], 'method' => 'POST']) !!}
				<input type="hidden" name="pageID" value="{{$page->id}}"/>
					<input type="hidden" name="mediaType" value="image"/>
					<li><button type="submit" name="btnRemoveImage">Remove Image</button></li>
				{!! Form::close() !!}
			@endif

			@if (isset($pageData->video_path) AND $pageData->video_path != "")
				{!! Form::open(['route' => ['dashboard.advert.page.removeMedia', $page->advert_id, $page->id], 'method' => 'POST']) !!}
					<input type="hidden" name="mediaType" value="video"/>
					<li><button type="submit" name="btnRemoveVideo">Remove Video</button></li>
				{!! Form::close() !!}
			@endif

			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
</div>
@endsection
