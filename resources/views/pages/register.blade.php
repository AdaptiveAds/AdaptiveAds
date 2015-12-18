@extends('default')

@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="register" name="register" action="register" method="get" accept-charset="utf-8">
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
			<input type="passwordvalidation" name="passwordvalidation" placeholder="Re-type Password" required>
		</li>

		<li><input class="submit" type="submit" value="Login"></li>
	</ul>
	<ul>
		<li><a href="../index.php?action=registration">Register</a></li>
		<li><a href="*RunScript for reset">Forgot Password</a></li>
	</ul>
</form>

@endsection
