<ul name="lstTemplates">
  @if(isset($templates))
    @if($templates->count() > 0)
      @foreach($templates as $template)
        <li>
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

            {{-- Show correct button to disable ot enable --}}
            {!! Form::open(['route' => ['dashboard.settings.templates.toggleDeleted', $template->id], 'method' => 'POST']) !!}
              @if ($template->deleted == 0)
                <button type="submit" name="btnDisable">Disable</button>
              @else
                <button type="submit" name="btnEnable">Enable</button>
              @endif
            {!! Form::close() !!}
          @endif
        </li>
      @endforeach
    @else
      <li name="itmNone">
        <h3>No templates found.</h3>
      </li>
    @endif
  @endif
</ul>
