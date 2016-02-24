@extends('default')

@section('content')

{!! Form::open(['url' => 'login', 'method' => 'POST', 'id' => 'clientlogin']) !!}
	{!! csrf_field() !!}
	<ul>
		@if ($errors->any())
		  <div class="alert alert-danger">
		    @foreach($errors->getMessages() as $error)
					{{ $error[0] }}
				@endforeach
		  </div>
		@endif
		<li>
			<label for="usermail">Username</label>
			<input type="username" name="login" placeholder="Email or Username" required>
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
{!! Form::close() !!}
@endsection
