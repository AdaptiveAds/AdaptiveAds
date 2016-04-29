@extends('backend')

@section('content')

<div class="settings">
	<div class="row">
		<form name="adminUserSearch" action="index_submit" method="get" accept-charset="utf-8">
		<h3>Admins</h3>
			<ul>
				<li>
					<input type="name" name="txtName" placeholder="Name" required>
					<button name="btnFind" type="button">Find</button>
				</li>
			</ul>
		</form>
	</div>

	<div class="row">
		<form name="adminUserList" action="index_submit" method="get" accept-charset="utf-8">
			<ul>
				<li>
					<label name="lblUsername" for="username">Username</label>
					<button name="btnEdit" type="button">Edit</button>
					<button name="btnDisable" type="button">Disable</button>
				</li>
				<li>
					<label name="lblUsername" for="username">Username</label>
					<button name="btnEdit" type="button">Edit</button>
					<button name="btnDisable" type="button">Disable</button>
				</li>
				<li>
					<label name="lblUsername" for="username">Username</label>
					<button name="btnEdit" type="button">Edit</button>
					<button name="btnDisable" type="button">Disable</button>
				</li>

			</ul>
		</form>
	</div>
</div>
@endsection
