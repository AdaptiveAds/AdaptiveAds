@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST']) !!}
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
      @if (isset($user))
        @if ($user->is_super_user)
          <li>
    				<label for="chkIsSuper">Is super user</label>
    				<input type="checkbox" name="chkIsSuper" required>
    			</li>
        @endif
      @endif
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
				<button type="submit" name="btnSave">Save</button>
			</li>
		</ul>
  {!! Form::close() !!}
</div>
@endsection
