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
		<h3>Delete Mode</h3>
		<h5>Remove selected adverts from playlist</h5>
		<ul>
			<li>
				<button name="btnRemove" type="button">Remove</button>
			</li>
		</ul>
	</div>

	<div class="row">
		@include('objects/listAdverts', array('selectable' => true))
	</div>
</div>
@endsection
