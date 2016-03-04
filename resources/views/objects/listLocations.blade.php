<ul name="lstLocationItems">
  @if (isset($locations))
    @if ($locations->count() > 0)
      @foreach($locations as $location)
        <li>
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


            {{-- Show correct button to disable ot enable --}}
            {!! Form::open(['route' => ['dashboard.settings.locations.destroy', $location->id],
                            'method' => 'DELETE',
                            'onsubmit' => 'return ConfirmDelete()']) !!}
              <button type="submit" name="btnDelete">Delete</button>
            {!! Form::close() !!}
          @endif
        </li>
      @endforeach
    @else
      <li name="itmNone">
        <h3>No locations found</h3>
      </li>
    @endif
  @endif
</ul>
