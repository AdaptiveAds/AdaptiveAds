@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST']) !!}
		<ul>
			<li>
				<label>Username:</label>
				<input title="username" type="username" name="username" placeholder="johnsmith" required>
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
				<input title="Password"  type="password" name="password" placeholder="Min 6 chars" required>
			</li>
			<li>
				<label>Re-type Pass:</label>
				<input title="Confirm Password"  type="password" name="password_confirmation" placeholder="Confirm" required>
			</li>
			<li>
				<button type="submit" name="btnSave">Save</button>
			</li>
		</ul>
  {!! Form::close() !!}
</div>
@endsection
