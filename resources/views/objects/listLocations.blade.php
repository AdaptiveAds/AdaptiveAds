<ul name="lstLocationItems">
  @if (isset($locations))
    @if ($locations->count() > 0)
      @foreach($locations as $location)
        <li class="listItem" name="{{ $location->name or 'Location name' }}">
          <a href="#">
            {{ $location->name or 'Location name' }}
          </a>

          {{-- Only show edit options if in mode --}}
          @if (isset($editMode))

            <a href="#LocationsModal" data-displayEditModal="true"
                                      data-modalObject="Locations"
                                      data-modalMethod="PUT"
                                      data-modalRoute="{{ URL::route('dashboard.settings.locations.update', $location->id) }}"
                                      data-userID="{{ $location->id }}">
              <button type="button" name="btnEdit">Edit</button>
            </a>

            <a href="#DeleteModal" data-displayDeleteModal="true"
                                      data-modalObject="Delete"
                                      data-modalMethod="DELETE"
                                      data-modalRoute="{{ URL::route('dashboard.settings.locations.destroy', $location->id) }}"
                                      data-userID="{{ $location->id }}">
              <button type="button" name="btnDelete">Delete</button>
            </a>
          @endif
        </li>
      @endforeach
    @else
      <li name="itmNone" class="listItem">
        <h3>No locations found</h3>
      </li>
    @endif
  @endif
</ul>
