<ul>
  @if(isset($screens))
    @if($screens->count() > 0)
      @foreach($screens as $screen)
        <li>
          <a href="#ScreensModal" data-displayEditModal="true"
                                    data-modalObject="Screens"
                                    data-modalMethod="PUT"
                                    data-modalRoute="{{ URL::route('dashboard.settings.screens.update', $screen->id) }}"
                                    data-userID="{{ $screen->id }}">
            {{ $screen->id }}
          </a>
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
