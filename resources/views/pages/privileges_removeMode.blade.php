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
				<h3>Remove Mode</h3>
				@if (Session::has('message'))
					<h5>{{Session::pull('message')}}</h5>
				@else
					<h5>Remove user(s) from {{$department->name or 'a department'}}</h5>
				@endif
				<ul name="lstPrivilegeControls">
					<li>
						<button type="button" name="btnRemove">Remove</button>
					</li>
					<li>
						<input type="checkbox" id="checkAll" name="chkAll"/>
						<label for="checkAll">Check All</label>
					</li>
				</ul>
	</div>

	<div class="row">
		@include('objects/listPermissions', array('selectable' => true))
	</div>
</div>
@endsection
