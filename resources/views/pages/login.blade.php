@extends('default')

@section('content')

<form id="clientlogin" name="login" action="login" method="POST" accept-charset="utf-8">
	{!! csrf_field() !!}
	<ul>
		<li>
			<label for="usermail">Username</label>
			<input type="username" name="username" placeholder="Email or Username" required>
		</li>
		<li>
			<label for="password">Password</label>
			<input type="password" name="password" placeholder="password" required>
		</li>
		<button class="submit" type="submit">Login</button>
	</ul>
	<ul>
		<li><a href="{{ URL::to('auth/register') }}">Register</a></li>
		<li><a href="*RunScript for reset">Forgot Password</a></li>
	</ul>
</form>
@endsection
