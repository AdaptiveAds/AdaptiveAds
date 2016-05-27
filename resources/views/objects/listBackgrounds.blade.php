<ul name="lstBackgrounds">
  @if(isset($backgrounds))
    @if($backgrounds->count() > 0)
      @foreach($backgrounds as $background)
        <li class="listItem" name="{{ $background->name }}">
          <a href="#">
            {{ $background->name }}
          </a>

          {{-- Only show edit options if in mode --}}
          @if (isset($editMode))
            <a href="#BackgroundsModal" data-displayEditModal="true"
                                      data-modalObject="Backgrounds"
                                      data-modalMethod="PUT"
                                      data-modalRoute="{{ URL::route('dashboard.settings.backgrounds.update', $background->id) }}"
                                      data-userID="{{ $background->id }}">
              <button type="button" name="btnEdit">Edit</button>
            </a>

            <a href="#DeleteModal" data-displayDeleteModal="true"
                      data-modalObject="Delete"
                      data-modalMethod="DELETE"
                      data-modalRoute="{{ URL::route('dashboard.settings.backgrounds.destroy', $background->id)}}">
                      <button type="button" name="btnDeleted">Delete</button>
            </a>
          @endif
        </li>
      @endforeach
    @else
      <li name="itmNone" class="listItem">
        <h3>No backgrounds found.</h3>
      </li>
    @endif
  @endif
</ul>
