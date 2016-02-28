@extends('default')

@section('content')

@include('objects/modal_error', array('object' => 'Error'))

<script>
	$('document').ready(function() {
		ObjectAssign.token = "{{ csrf_token() }}";
		ObjectAssign.action = "/dashboard/playlist/process";

		SelectManager.multi = true;
		SelectManager.register_eventhandlers();
		ObjectAssign.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			<h3>Add Mode</h3>
			@if (Session::has('message'))
				<h5>{{Session::pull('message')}}</h5>
			@else
				<h5>Add an existing advert to {{$playlist->name or 'the playlist'}}</h5>
			@endif
			<ul>
				<li>
					<button name="btnAdd" type="button">Add</button>
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/listAdverts', array('selectable' => true))
	</div>
</div>
@endsection
