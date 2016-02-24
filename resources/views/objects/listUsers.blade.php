<ul name="lstUsers">
  @if (isset($users))
    @if ($users->count() > 0)
      @foreach($users as $user)
        <li data-userID="{{ $user->id }}">
          <a href="#">{{ $user->username }}</a>

          <a href="#UsersModal" data-displayEditModal="true"
											data-modalObject="Users"
                      data-modalMethod="PUT"
											data-modalRoute="{{ URL::route('dashboard.settings.users.update', $user->id)}}"
                      data-userID="{{ $user->id }}">
            <button type="button" name="btnEdit">Edit</button>
          </a>

          {{-- Show correct button to disable ot enable --}}
          {!! Form::open(['route' => ['dashboard.settings.users.toggleDeleted', $user->id], 'method' => 'POST']) !!}
          @if ($user->deleted == 0)
            <button type="submit" name="btnDisable">Disable</button>
          @else
            <button type="submit" name="btnEnable">Enable</button>
          @endif
          {!! Form::close() !!}
        </li>
      @endforeach
    @else
      <li>
        <h3>No users found or un-authorised access</h3>
      </li>
    @endif
  @endif
</ul>
