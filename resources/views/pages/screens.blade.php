@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		<!-- TODO REMOVE FORM -->
		<form>
		<h3>Screens</h3>
			<ul>
				<li>
					<input type="name" name="name" placeholder="Name" required>
					@include('objects/departments_dropdown', array('allowed_departments' => $allowed_departments))
					<button type="button">Add</button>
					<button type="button">Find</button>
				</li>
			</ul>
		</form>
	</div>

	<div class="row">
		<!-- TODO REMOVE FORM -->
		<form>
			@include('objects/screenItems')
		</form>
	</div>
</div>
@endsection
