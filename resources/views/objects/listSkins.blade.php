<ul name="lstSkins">
  @if(isset($skins))
    @if($skins->count() > 0)
      @foreach($skins as $skin)
        <li>
          <a href="#">
            {{ $skin->name }}
          </a>

          <a href="#SkinsModal" data-displayEditModal="true"
                                    data-modalObject="Skins"
                                    data-modalMethod="PUT"
                                    data-modalRoute="{{ URL::route('dashboard.settings.skins.update', $skin->id) }}"
                                    data-userID="{{ $skin->id }}">
            <button type="button" name="btnEdit">Edit</button>
          </a>

          {{-- Show correct button to disable ot enable --}}
          {!! Form::open(['route' => ['dashboard.settings.skins.toggleDeleted', $skin->id], 'method' => 'POST']) !!}
            @if ($skin->deleted == 0)
              <button type="submit" name="btnDisable">Disable</button>
            @else
              <button type="submit" name="btnEnable">Enable</button>
            @endif
          {!! Form::close() !!}
        </li>
      @endforeach
    @else
      <li name="itmNone">
        <h3>No templates found.</h3>
      </li>
    @endif
  @endif
</ul>
