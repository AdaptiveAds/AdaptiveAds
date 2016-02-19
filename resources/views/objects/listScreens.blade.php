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

          {{-- Show correct button to disable ot enable --}}
          {!! Form::open(['route' => ['dashboard.settings.screens.toggleDeleted', $screen->id], 'method' => 'POST']) !!}
          @if ($screen->deleted == 0)
            <button type="submit" name="btnDisable">Disable</button>
          @else
            <button type="submit" name="btnEnable">Enable</button>
          @endif
          {!! Form::close() !!}
        </li>
      @endforeach
    @else
      <li>
        <h3>No screens found.</h3>
      </li>
    @endif
  @endif
</ul>
