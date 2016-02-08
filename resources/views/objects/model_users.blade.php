<div id="{{$object or 'object'}}Modal" class="modalDialog">
  <div>
    <a href="#close" class="close">X</a>
    <h4>Create new {{$object or 'object'}}</h4>
    {!! Form::open(['route' => $route, 'method' => 'POST']) !!}
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
    {!! Form::close() !!}
  </div>
</div>
