@extends('backend')

@section('content')

<script>
	$('document').ready(function() {
		IndexUpdater.token = '{{ csrf_token() }}';
		IndexUpdater.action = '/dashboard/advert/{{$advert->id}}/updateIndexes';
		SelectManager.register_eventhandlers();
		IndexUpdater.register_eventhandlers();

		BackgroundUpdater.token = '{{ csrf_token() }}';
		BackgroundUpdater.action = '/dashboard/advert/{{$advert->id}}/updateBackground';
		BackgroundUpdater.register_eventhandlers();
		BackgroundUpdater.updateDropdown('{{$advert->background_id or 1}}');
	});
</script>

<div class="global">
	<div class="row">
			<h3>Advert Editor - {{ $advert->name or '' }}</h3>
			@if (Session::has('message'))
				<h5>{{Session::pull('message')}}</h5>
			@else
				<h5>Manage advert pages and update their indexes</h5>
			@endif
			<ul>
				<li>
 					@if (isset($advert))
					  <label>Advert background:</label>
						@include('objects/dropdown_backgrounds')
						<button name="btnUp" id="btnUp" type="button" disabled>Up</button>
	 					<button name="btnDown" id="btnDown" type="button" disabled>Down</button>
						<button name="btnNewPage" type="button"  onclick="location.href='{{ URL::route('dashboard.advert.{adID}.page.create', $advert->id) }}';">+ New Page</button>
					@endif
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/listPages', array('selectable' => true))
	</div>
</div>

@endsection
