<ul>
  @if (isset($locations))
    @if ($locations->count() > 0)
      @foreach($locations as $location)
        <li>
          <label for="name">{{ $location->name or 'Location name' }}</label>
          <button type="button">Edit</button>
          <button type="button">Disable</button>
        </li>
      @endforeach
    @else
      <li>
        <h3>No locations found</h3>
      </li>
    @endif
  @endif
</ul>
