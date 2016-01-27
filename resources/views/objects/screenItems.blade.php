<ul>
  @if(isset($screens))
    @if($screens->count() > 0)
      @foreach($screens as $screen)
        <li>
          <label for="name">{{ $screen->id }}</label>
          <button type="button">Edit</button>
          <button type="button">Disable</button>
        </li>
      @endforeach
    @else
      <li>
        <h3>No screens found.</h3>
      </li>
    @endif
  @endif
</ul>
