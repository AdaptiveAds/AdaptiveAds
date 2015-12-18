@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		<form name="locationsSearch" action="index_submit" method="get" accept-charset="utf-8">
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
		<form name="locationList" action="index_submit" method="get" accept-charset="utf-8">
			<ul>
				<li>
					<label for="name">Name</label>
					<button type="button">Edit</button>
					<button type="button">Disable</button>
				</li>
				<li>
					<label for="name">Name</label>
					<button type="button">Edit</button>
					<button type="button">Disable</button>
				</li>
				<li>
					<label for="name">Name</label>
					<button type="button">Edit</button>
					<button type="button">Disable</button>
				</li>
			</ul>
		</form>
	</div>
</div>
@endsection
