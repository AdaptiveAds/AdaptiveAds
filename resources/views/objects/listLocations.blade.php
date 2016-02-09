<ul name="lstLocationItems">
  @if (isset($locations))
    @if ($locations->count() > 0)
      @foreach($locations as $location)
        <li>
          {!! Form::open(['url' => '', 'method' => 'POST']) !!}
            <label for="name">{{ $location->name or 'Location name' }}</label>
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
