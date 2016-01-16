@extends('default')

@section('content')

<form id="retrievePassword" name="retrievePassword" action="retrievePassword" method="POST" accept-charset="utf-8">
	{!! csrf_field() !!}
	<ul>
		<li>
			<label for="email">Email</label>
			<input type="email" name="email" placeholder="Email" required>
		</li>
		<li>
      RECAPTCHA GOES HERE
		</li>
		<input class="submit" type="submit" value="Login">
	</ul>
</form>

@endsection
