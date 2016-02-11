<ul name="lstLocationItems">
  @if (isset($locations))
    @if ($locations->count() > 0)
      @foreach($locations as $location)
        <li>
          {!! Form::open(['url' => '', 'method' => 'POST']) !!}
          <a href="#LocationsModal" data-displayEditModal="true"
                     data-modalObject="Locations"
                     data-modalMethod="PUT"
                     data-modalRoute="{{ URL::route('dashboard.settings.locations.update', $location->id) }}"
                     data-userID="{{ $location->id }}">
              {{ $location->name or 'Location name' }}
            </a>
            <button name="btnEditLocation">Edit</button>
            <button type="submit" name="btnDisable">Disable</button>
          {!! Form::close() !!}
        </li>
      @endforeach
    @else
      <li name="itmNone">
        <h3>No locations found</h3>
      </li>
    @endif
  @endif
</ul>
