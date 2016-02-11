<ul name="listUsers">
  @if (isset($users))
    @if ($users->count() > 0)
      @foreach($users as $user)
        <li>
          <a href="#UsersModal" data-displayEditModal="true"
											data-modalObject="Users"
                      data-modalMethod="PUT"
											data-modalRoute="{{ URL::route('dashboard.settings.users.update', $user->id)}}"
                      data-userID="{{ $user->id }}">
            {{ $user->username }}
          </a>
          <button type="submit" name="btnDisable">Disable</button>
          <button type="submit" name="btnEnable">Enable</button>
        </li>
      @endforeach
    @else
      <li>
        <h3>No users found or un-authorised access</h3>
      </li>
    @endif
  @endif
</ul>
