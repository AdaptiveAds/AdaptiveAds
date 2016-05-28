@extends('backend')

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
			<input class="clearable" type="username" name="login" placeholder="username" required>
		</li>
		<li>
			<label for="password">Password</label>
			<input  class="clearable" type="password" name="password" placeholder="password" required>
		</li>
		<button class="submit" type="submit">Login</button>
	</ul>
	<ul>
		<!-- KW. 10.01.16
		No longer required as client will manage this internally.
		Code not deleted to show it was considered.
		<li><a href="{{ URL::to('auth/register') }}">Register</a></li>
		<li><a href="*RunScript for reset">Forgot Password</a></li>-->
	</ul>
{!! Form::close() !!}
@endsection
