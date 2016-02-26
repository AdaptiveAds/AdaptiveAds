<ul name="lstUsers">
  @if (isset($users))
    @if ($users->count() > 0)
      @foreach($users as $user)
        <li data-userID="{{ $user->id }}">
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

            @if ($user->is_super_user)
              {{-- Show correct button to disable ot enable --}}
              {!! Form::open(['route' => ['dashboard.settings.users.destroy', $user->id],
                              'method' => 'DELETE',
                              'onsubmit' => 'return ConfirmDelete()']) !!}
                <button type="submit" name="btnDeleted">Delete</button>
              {!! Form::close() !!}
            @endif
          @endif
        </li>
      @endforeach
    @else
      <li>
        <h3>No users found or un-authorised access</h3>
      </li>
    @endif
  @endif
</ul>
