@extends('default')

@section('content')

<script>
	$('document').ready(function() {
		IndexUpdater.token = '{{ csrf_token() }}';
		IndexUpdater.action = '/dashboard/advert/{{$advert->id}}/updateIndexes';
		SelectManager.register_eventhandlers();
		IndexUpdater.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			<h3>Advert Editor - {{ $advert->name or '' }}</h3>
			<ul>
				<li>
 					@if (isset($advert))
						{!! Form::open(['route' => 'dashboard.advert.process', 'method' => 'POST']) !!}
						<input type="text" name="txtPageName" placeholder="Page name...."
									 value="{{ $searchItem or '' }}"/>
						<button name="btnUp" id="btnUp" type="button" disabled>Up</button>
	 					<button name="btnDown" id="btnDown" type="button" disabled>Down</button>
						<button name="btnNewPage" type="button"  onclick="location.href='{{ URL::route('dashboard.advert.{adID}.page.create', $advert->id) }}';">+ New Page</button>
						<button name="btnDeleteAdvert" type="submit">Delete Ad</button>
						{!! Form::close() !!}
					@endif
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/listPages', array('selectable' => true))
	</div>
</div>

@endsection
