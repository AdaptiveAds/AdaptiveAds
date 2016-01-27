<ul>
  @if (isset($users))
    @if ($users->count() > 0)
      @foreach($users as $user)
        <li>
          <label for="username">{{ $user->username }}</label>
          <button type="button">Edit</button>
          <button type="button">Disable</button>
        </li>
      @endforeach
    @else
      <li>
        <h3>No users found or un-authorised access</h3>
      </li>
    @endif
  @endif
</ul>
