<ul name="lstSkins">
  @if(isset($skins))
    @if($skins->count() > 0)
      @foreach($skins as $skin)
        <li class="listItem" name="{{ $skin->name }}">
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

            <a href="#DeleteModal" data-displayDeleteModal="true"
                      data-modalObject="Delete"
                      data-modalMethod="DELETE"
                      data-modalRoute="{{ URL::route('dashboard.settings.skins.destroy', $skin->id)}}">
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
