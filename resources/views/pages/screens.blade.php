@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		<form name="screenList" action="index_submit" method="get" accept-charset="utf-8">
		<h3>Screens</h3>
			<ul>
				<li>
					<input type="name" name="name" placeholder="Name" required>
					<select>
						<option value="select">Select Location</option>
						<option value="cafe">Cafe</option>
						<option value="library">Library</option>
						<option value="media">Media</option>
						<option value="marketing">Marketing</option>
					</select>
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
