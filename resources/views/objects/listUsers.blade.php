<ul name="lstUsers">
  @if (isset($users))
    @if ($users->count() > 0)
      @foreach($users as $user)
        <li data-userID="{{ $user->id }}" class="listItem" name="{{ $user->username }}">
          <a href="#">{{ $user->username }}</a>

          {{-- Only show edit options if in mode --}}
          @if (isset($editMode))
            <a href="#UsersModal" data-displayEditModal="true"
  											data-modalObject="Users"
                        data-modalMethod="PUT"
  											data-modalRoute="{{ URL::route('dashboard.settings.users.update', $user->id)}}"
                        data-userID="{{ $user->id }}">
                        <button type="button" name="btnEdit">Edit</button>
            </a>

            @if ($requestUser->is_super_user)
              <a href="#DeleteModal" data-displayDeleteModal="true"
                        data-modalObject="Delete"
                        data-modalMethod="DELETE"
                        data-modalRoute="{{ URL::route('dashboard.settings.users.destroy', $user->id)}}">
                        <button type="button" name="btnDeleted">Delete</button>
              </a>
            @endif
          @endif
        </li>
      @endforeach
    @else
      <li name="itmNone" class="listItem">
        <h3>No users found or un-authorised access</h3>
      </li>
    @endif
  @endif
</ul>
