@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		<form name="dashboardUserDetails" action="index_submit" method="get" accept-charset="utf-8">
		<h3>User Settings</h3>
			<ul>
				<li><input title="username" type="name" name="username" placeholder="Username" required></li>
				<li>
					<input title="First Name" type="name" name="firstname" placeholder="Joe" required>
					<input title="Surname"  type="name" name="surname" placeholder="Blogs" required>
				</li>
				<li><input title="Enter Email" type="name" name="email" placeholder="Enter Email Address" required></li>
				<li><input title="Confirm Email" type="name" name="emailVal" placeholder="Confirm Email Address" required></li>
				<li><input title="Password"  type="name" name="password" placeholder="Enter Password" required></li>
				<li><input title="Confirm Password"  type="name" name="passwordVal" placeholder="Confirm Email" required></li>
				<li>
					<input title="Tick to accept"  type="checkbox" name="AdsNews" value="signup"> Sign up to Ads News
					<button type="button">Edit</button>

				</li>
			</ul>
		</form>
	</div>

<h4>Options</h4>
	<section>
		<article>
			<ul>
				<li>
					<a href="../index.php?action=users">
						<i class="fa fa-users"></i>
						<p>Users</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=locations">
						<i class="fa fa-map-marker"></i>
						<p>Locations</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=screens">
						<i class="fa fa-desktop"></i>
						<p>Screens</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=pageeditorHor">
						<i class="fa fa-pencil-square-o"></i>
						<!-- temp name ofc -->
						<p>Page Editor</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=adverts">
						<i class="fa fa-list-ul"></i>
						<!-- temp name ofc -->
						<p>Adverts</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=advertEditor">
						<i class="fa fa-pencil-square-o"></i>
						<!-- temp name ofc -->
						<p>Advert Editor</p>
					</a>
				</li>

			</ul>

			<div class="clear"></div>
		</article>
	</section>

<hr></hr>
<h4>Admin Settings</h4>
	<section>
		<article>
			<ul>
				<li>
					<a href="../index.php?action=users">
						<i class="fa fa-users"></i>
						<p>Users</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=locations">
						<i class="fa fa-map-marker"></i>
						<p>Locations</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=screens">
						<i class="fa fa-desktop"></i>
						<p>Screens</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=pageeditorHor">
						<i class="fa fa-pencil-square-o"></i>
						<!-- temp name ofc -->
						<p>Page Editor</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=adverts">
						<i class="fa fa-list-ul"></i>
						<!-- temp name ofc -->
						<p>Adverts</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=advertEditor">
						<i class="fa fa-pencil-square-o"></i>
						<!-- temp name ofc -->
						<p>Advert Editor</p>
					</a>
				</li>

			</ul>

			<div class="clear"></div>
		</article>
	</section>

<hr></hr>
<h4>Super User Settings</h4>
	<section>
		<article>
			<ul>
				<li>
					<a href="../index.php?action=admins.htm">
						<i class="fa fa-users"></i>
						<p>Admins</p>
					</a>
				</li>
				<li>
					<a href="../index.php?action=locations.htm">
						<i class="fa fa-map-marker"></i>
						<p>Locations</p>
					</a>
				</li>

			</ul>

			<div class="clear"></div>
		</article>
	</section>
</div>
@endsection
