<ul name="lstTemplates">
  @if(isset($templates))
    @if($templates->count() > 0)
      @foreach($templates as $template)
        <li>
          <a href="#TemplatesModal" data-displayEditModal="true"
                     data-modalObject="Templates"
                     data-modalMethod="PUT"
                     data-modalRoute="{{ URL::route('dashboard.settings.templates.update', $template->id) }}"
                     data-userID="{{ $template->id }}">
            {{ $template->name }}
          </a>
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
