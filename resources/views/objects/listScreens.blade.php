<ul>
  @if(isset($screens))
    @if($screens->count() > 0)
      @foreach($screens as $screen)
        <li class="listItem" name="{{ $screen->id }}">
          <a href="#">
            {{ $screen->id }}
          </a>

          {{-- Only show edit options if in mode --}}
          @if (isset($editMode))
            <a href="#ScreensModal" data-displayEditModal="true"
                                      data-modalObject="Screens"
                                      data-modalMethod="PUT"
                                      data-modalRoute="{{ URL::route('dashboard.settings.screens.update', $screen->id) }}"
                                      data-userID="{{ $screen->id }}">
              <button type="button" name="btnEdit">Edit</button>
            </a>

            @if ($user->is_super_user)
              <a href="#DeleteModal" data-displayDeleteModal="true"
                        data-modalObject="Delete"
                        data-modalMethod="DELETE"
                        data-modalRoute="{{ URL::route('dashboard.settings.screens.destroy', $screen->id)}}">
                        <button type="button" name="btnDeleted">Delete</button>
              </a>
            @endif
          @endif
        </li>
      @endforeach
    @else
      <li name="itmNone" class="listItem">
        <h3>No screens found.</h3>
      </li>
    @endif
  @endif
</ul>
