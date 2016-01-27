@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		<!-- TODO REMOVE FORM -->
		<form>
		<h3>Locations</h3>
			<ul>
				<li>
					<input type="name" name="name" placeholder="Name" required>
					<button type="button">Add</button>
					<button type="button">Find</button>
				</li>
			</ul>
		</form>
	</div>

	<div class="row">
		<!-- TODO REMOVE FORM -->
			<form>
			@include('objects/locationItems')
		</form>
	</div>
</div>
@endsection
