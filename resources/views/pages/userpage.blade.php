@extends('backend')

@section('content')

<div class="settings">
	<div class="row">
		<form name="userPermissionsSearch" action="index_submit" method="get" accept-charset="utf-8">
		<h3>User Details</h3>
			<ul>
				<li><input type="name" name="username" placeholder="Username" required></li>
				<li>
					<input type="name" name="firstname" placeholder="Joe" required>
					<input type="name" name="surname" placeholder="Blogs" required>
				</li>
				<li><input type="name" name="email" placeholder="Email" required>	</li>
				<li>
					<button type="button" style="float:right;">Save</button>
					<button type="button" style="float:right;">Delete</button>
					<button type="button" style="float:right;">Reset</button>
				</li>
				<li><input type="checkbox" name="AdsNews" value="signup"> Sign up to Ads News</li>

			</ul>
		</form>
	</div>

<hr></hr>
	<div class="row">
		<form name="screenList" action="index_submit" method="get" accept-charset="utf-8">
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
		<form name="userPermissions" action="index_submit" method="get" accept-charset="utf-8">
			<!-- Hide the plus or minus based click (toggle would suit) -->
			<button type="button" style="float:right">+</button>
			<button type="button" style="float:right">-</button>
			<h3>Permissions</h3>
			<ul>
				<li>
					<label for="name">Name</label>
					<button type="remove">Remove</button>
				</li>
				<li>
					<label for="name">Name</label>
					<button type="remove">Remove</button>
				</li>
				<li>
					<label for="name">Name</label>
					<button type="remove">Remove</button>
				</li>
			</ul>
		</form>
	</div>
</div>
@endsection
