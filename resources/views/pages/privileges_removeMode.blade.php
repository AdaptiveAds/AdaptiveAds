@extends('default')

@section('content')

@include('objects/modal_error', array('object' => 'Error'))

<script>
	$('document').ready(function() {
		ObjectAssign.token = "{{ csrf_token() }}";
		ObjectAssign.action = "/dashboard/settings/privileges/process";

		SelectManager.multi = true;
		SelectManager.register_eventhandlers();
		ObjectAssign.register_eventhandlers(); // Must be after select manager
	});
</script>

<div class="global">
	<div class="row">
				<h3>Remove Privileges</h3>
				@if (Session::has('message'))
					<div>
						<h4>{{Session::get('message')}}</h4>
					</div>
				@endif
				<ul name="lstPrivilegeControls">
					<li>
						<button type="button" name="btnRemove">Remove</button>
					</li>
				</ul>
	</div>

	<div class="row">
		@include('objects/listPermissions', array('selectable' => true))
	</div>
</div>
@endsection
