<ul>
  @if (isset($users))
    @foreach($users as $user)
      <li>
        <label for="username">{{ $user->username }}</label>
        <button type="button">Edit</button>
        <button type="button">Disable</button>
      </li>
    @endforeach
  @else
    <h3>No users found or un-authorised access</h3>
  @endif
</ul>
