<ul name="lstPermissions" data-selectableList="true">
  @if (isset($users))
    @if ($users->count() > 0)
      @foreach($users as $user)
        <li data-itemID="{{ $user->id }}">
          <a href="#">

            @if (isset($selectable))
              @if ($selectable == true)
                <input type="checkbox" data-selectableItem="true" name="chkSelectUser_{{ $user->id }}"/>
              @endif
            @endif
            <label for="chkSelectUser_">{{ $user->username }}</label>

          </a>

          @if (isset($selectable) == false)
            {!! Form::open(['route' => 'dashboard.settings.privileges.process', 'method' => 'POST']) !!}
              <input type="hidden" name="userID" value="{{$user->id}}"/>
              @if ($user->is_super_user == false)
                @if ($user->isAdmin($department->id))
                  <button type="submit" name="btnToggle">Make User</button>
                @else
                  <button type="submit" name="btnToggle">Make Admin</button>
                @endif
              @endif
            {!! Form::close() !!}
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
