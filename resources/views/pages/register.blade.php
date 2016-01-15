@extends('default')

@section('content')

<form id="register" name="register" action="register" method="POST" accept-charset="utf-8">
	{!! csrf_field() !!}
	<ul>
		<li>
			<label for="email">Email</label>
			<input type="email" name="email" placeholder="Email" required>
		</li>
		<li>
			<label for="username">Username</label>
			<input type="username" name="username" placeholder="Username" required>
		</li>
		<li>
			<label for="password">Password</label>
			<input type="password" name="password" placeholder="Password" required>
		</li>
		<li>
			<label for="passwordvalidation">Re-type Password</label>
			<input type="password" name="password_confirmation" placeholder="Re-type Password" required>
		</li>

		<input class="submit" type="submit" value="Login">
	</ul>
	<ul>
		<li><a href="../index.php?action=registration">Register</a></li>
		<li><a href="*RunScript for reset">Forgot Password</a></li>
	</ul>
</form>

@endsection
