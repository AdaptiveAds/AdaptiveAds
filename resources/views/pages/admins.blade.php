@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		<form name="adminUserSearch" action="index_submit" method="get" accept-charset="utf-8">
		<h3>Admins</h3>
			<ul>
				<li>
					<input type="name" name="name" placeholder="Name" required>
					<button type="button">Find</button>
				</li>
			</ul>
		</form>
	</div>

	<div class="row">
		<form name="adminUserList" action="index_submit" method="get" accept-charset="utf-8">
			<ul>
				<li>
					<label for="username">Username</label>
					<button type="button">Edit</button>
					<button type="button">Disable</button>
				</li>
				<li>
					<label for="username">Username</label>
					<button type="button">Edit</button>
					<button type="button">Disable</button>
				</li>
				<li>
					<label for="username">Username</label>
					<button type="button">Edit</button>
					<button type="button">Disable</button>
				</li>

			</ul>
		</form>
	</div>
</div>
@endsection
