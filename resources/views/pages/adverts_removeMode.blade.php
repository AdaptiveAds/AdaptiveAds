@extends('backend')

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
		<h3>Remove Mode</h3>
		@if (Session::has('message'))
			<h5>{{Session::pull('message')}}</h5>
		@else
			<h5>Remove selected adverts from {{$playlist->name or 'playlist'}}</h5>
		@endif
		<ul>
			<li>
				<button name="btnRemove" type="button">Remove</button>
			</li>
			<li>
				<input type="checkbox" id="checkAll" name="chkAll"/>
				<label for="checkAll">Check All</label>
			</li>
		</ul>
	</div>

	<div class="row">
		@include('objects/listAdverts', array('selectable' => true))
	</div>
</div>
@endsection
