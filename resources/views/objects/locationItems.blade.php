<ul>
  @if (isset($locations))
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
</ul>
