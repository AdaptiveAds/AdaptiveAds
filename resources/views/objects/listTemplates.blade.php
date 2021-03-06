<ul name="lstTemplates">
  @if(isset($templates))
    @if($templates->count() > 0)
      @foreach($templates as $template)
        <li class="listItem" name="{{ $template->name }}">
          <a href="#">
            {{ $template->name }}
          </a>

          {{-- Only show edit options if in mode --}}
          @if (isset($editMode))
            <a href="#TemplatesModal" data-displayEditModal="true"
                                      data-modalObject="Templates"
                                      data-modalMethod="PUT"
                                      data-modalRoute="{{ URL::route('dashboard.settings.templates.update', $template->id) }}"
                                      data-userID="{{ $template->id }}">
              <button type="button" name="btnEdit">Edit</button>
            </a>

            <a href="#DeleteModal" data-displayDeleteModal="true"
                      data-modalObject="Delete"
                      data-modalMethod="DELETE"
                      data-modalRoute="{{ URL::route('dashboard.settings.templates.destroy', $template->id)}}">
                      <button type="button" name="btnDeleted">Delete</button>
            </a>
          @endif
        </li>
      @endforeach
    @else
      <li name="itmNone" class="listItem">
        <h3>No templates found.</h3>
      </li>
    @endif
  @endif
</ul>
