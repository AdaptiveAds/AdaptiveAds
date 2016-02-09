<ul name="lstTemplates">
  @if(isset($templates))
    @if($templates->count() > 0)
      @foreach($templates as $template)
        <li>
          <label for="name">{{ $template->name }}</label>
          <button type="button">Edit</button>
          <button type="button">Disable</button>
        </li>
      @endforeach
    @else
      <li name="itmNone">
        <h3>No templates found.</h3>
      </li>
    @endif
  @endif
</ul>
