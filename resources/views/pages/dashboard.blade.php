@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		<form name="dashboardUserDetails" action="index_submit" method="get" accept-charset="utf-8">
		<h3>User Settings</h3>
			<ul>
				<li>
					<label>Username:</label>
					<input title="username" type="username" name="txtUsername" placeholder="johnsmith" required>
				</li>
				<li class="twoinputs">
					<label>Firstname:</label>
					<input title="First Name" type="name" name="txtFirstname" placeholder="John" required>
					<label class="smalllabel">Surname:</label>
					<input title="Surname"  type="name" name="txtSurname" placeholder="Smith" required>
				</li>
				<li>
					<label>Email:</label>
					<input title="Enter Email" type="email" name="txtEmail" placeholder="johnsmith@domain.com" required>
				</li>
				<li>
					<label>Re-type Emai:</label>
					<input title="Confirm Email" type="email" name="txtEmailConfirm" placeholder="johnsmith@domain.com" required>
				</li>
				<li>
					<label>Password:</label>
					<input title="Password"  type="name" name="txtPassword" placeholder="mypassword" required>
				</li>
				<li>
					<label>Re-type Pass:</label>
					<input title="Confirm Password"  type="password" name="txtPasswordConfirm" placeholder="mypassword" required>
				</li>
				<li>
					<input title="Tick to accept"  type="checkbox" name="AdsNews" value="signup"><span>Sign up to Ads News</span>
				</li>
				<li>
					<button type="button">Edit</button>
					<button type="button">Save</button>
				</li>
			</ul>
		</form>
	</div>

	<div class="row">
		<section>
			<h4 class="indent">Options</h4>
			<article>
				<ul>
					<li>
						<a href="{{ URL::to('dashboard/playlist')}}">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Playlists</span>
							</i>
						</a>
					</li>
					<li>
						<a href="{{ URL::to('dashboard/playlist/create')}}">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Create Playlist</span>
							</i>
						</a>
					</li>

					<li>
						<a href="{{ URL::to('dashboard/advert')}}">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Adverts</span>
							</i>
						</a>
					</li>
					<li>
						<a href="{{ URL::to('dashboard/advert/create')}}">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Create Advert</span>
							</i>
						</a>
					</li>
				</ul>
				<div class="clear"></div>
			</article>
		</section>

		<section>
			<h4>Admin Settings</h4>
			<article>
				<ul>

					<li>
						<a href="{{ URL::to('dashboard/settings/locations/')}}">
							<i class="fa fa-map-marker">
								<span>Locations</span>
							</i>
						</a>
					</li>
					<li>
						<a href="{{ URL::to('dashboard/settings/screens')}}">
							<i class="fa fa-desktop">
								<span>Screens</span>
							</i>
						</a>
					</li>
					<li>
						<a href="{{ URL::to('dashboard/settings/users')}}">
							<i class="fa fa-users">
								<span>Users</span>
							</i>
						</a>
					</li>
				</ul>
				<div class="clear"></div>
			</article>
		</section>

		<section>
			<h4>Super User Settings</h4>
			<article>
				<ul>
					<li>
						<a href="{{ URL::to('dashboard/settings/locations/')}}">
							<i class="fa fa-map-marker">
								<span>Locations</span>
							</i>
						</a>
					</li>
					<li>
						<a href="{{ URL::to(dashboard/'settings/screens')}}">
							<i class="fa fa-desktop">
								<span>Screens</span>
							</i>
						</a>
					</li>

					<li>
						<a href="{{ URL::to('dashboard/settings/users')}}">
							<i class="fa fa-users">
								<span>Admins</span>
							</i>
						</a>
					</li>
				</ul>
				<div class="clear"></div>
			</article>
		</section>
	</div><!-- row-->
</div>
@endsection
