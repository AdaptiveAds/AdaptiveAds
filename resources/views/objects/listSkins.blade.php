<ul name="lstSkins">
  @if(isset($skins))
    @if($skins->count() > 0)
      @foreach($skins as $skin)
        <li>
          <a href="#">
            {{ $skin->name }}
          </a>

          {{-- Only show edit options if in mode --}}
          @if (isset($editMode))
            <a href="#SkinsModal" data-displayEditModal="true"
                                      data-modalObject="Skins"
                                      data-modalMethod="PUT"
                                      data-modalRoute="{{ URL::route('dashboard.settings.skins.update', $skin->id) }}"
                                      data-userID="{{ $skin->id }}">
              <button type="button" name="btnEdit">Edit</button>
            </a>

            {{-- Show correct button to disable ot enable --}}
            {!! Form::open(['route' => ['dashboard.settings.skins.destroy', $skin->id], 'method' => 'DELETE']) !!}
              <button type="submit" name="btnDeleted">Delete</button>
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
