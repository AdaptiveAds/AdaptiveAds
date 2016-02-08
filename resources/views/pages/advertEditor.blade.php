@extends('default')

@section('content')

<script>
	$('document').ready(function() {
		SelectManager.token = '{{ csrf_token() }}';
		SelectManager.action = '/dashboard/advert/{{$advert->id}}/updateIndexes';
		SelectManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			<!-- TODO ADD FORM -->
			<h3>Advert Editor</h3>
			<ul>
				<li>
 					@if (isset($advert))
					{!! Form::open(['route' => ['dashboard.advert.destroy', $advert->id], 'method' => 'DELETE']) !!}
					<input type="name" name="txtPlaylistName" placeholder="Advert name...."
								 value="{{ $searchItem or '' }}"/>
					<button id="btnUp" type="button" disabled>Up</button>
 					<button id="btnDown" type="button" disabled>Down</button>
					<button type="button" name="btnNewPage" onclick="location.href='{{ URL::route('dashboard.advert.{adID}.page.create', $advert->id) }}';">+ New Page</button>
					<button name="btnDeleteAdvert" type="submit">Delete Ad</button>
					{!! Form::close() !!}
					@endif
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/pageItem')
	</div>
</div>

@endsection
