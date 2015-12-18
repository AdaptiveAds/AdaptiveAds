@extends('default')

@section('content')

<form id="clientlogin" name="login" action="login" method="get" accept-charset="utf-8">
	<ul>
		<li>
			<label for="usermail">Email</label>
			<input type="email" name="usermail" placeholder="Email or Username" required>
		</li>
		<li>
			<label for="password">Password</label>
			<input type="password" name="password" placeholder="password" required>
		</li>
		<li><input class="submit" type="submit" value="Login"></li>
	</ul>
	<ul>
		<li><a href="../index.php?action=register">Register</a></li>
		<li><a href="*RunScript for reset">Forgot Password</a></li>
	</ul>
</form>
@endsection
