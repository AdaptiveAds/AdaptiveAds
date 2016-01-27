<ul>
  @if(isset($departments))
    @if($departments->count() > 0)
      @foreach($departments as $department)
        <li>
          <label for="name">{{ $department->name }}</label>
          <button type="button">Edit</button>
          <button type="button">Disable</button>
        </li>
      @endforeach
    @else
      <li>
        <h3>No departments found.</h3>
      </li>
    @endif
  @endif
</ul>
