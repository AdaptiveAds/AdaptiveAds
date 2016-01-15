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
		<!-- submit button should not be inside <li> tag for formatting resasons -->
		<input class="submit" type="submit" value="Login">
	</ul>
	<ul>
		<li><a href="../index.php?action=register">Register</a></li>
		<li><a href="*RunScript for reset">Forgot Password</a></li>
	</ul>
</form>
@endsection
