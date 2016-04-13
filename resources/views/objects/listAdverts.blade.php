<ul data-selectableList="true" name="lstAdvertItems">
@if (isset($adverts))
  @if($adverts->count() > 0)
    @foreach($adverts as $advert)
      <!-- Only display select if we're adding to a playlist -->
      <li data-itemID="{{$advert->id}}" class="listItem" name="{{ $advert->name }}">
        <a href="{{ URL::route('dashboard.advert.edit', $advert->id) }}">

          @if ($selectable == true)
            <input type="checkbox" data-selectableItem="true" name="chkSelectAdvert_{{ $advert->id }}"/>
          @endif
          <label for="chkSelectAdvert_">{{ $advert->name }}</label>
        </a>

        @if (isset($editMode))

          <a href="#AdvertModal" data-displayEditModal="true"
                                 data-modalObject="Advert"
                                 data-modalMethod="PUT"
                                 data-modalRoute="{{ URL::route('dashboard.advert.update', $advert->id) }}"
                                 data-userID="{{ $advert->id }}">
            <button type="button" name="btnEdit">Edit</button>
          </a>


          {{-- Show correct button to disable ot enable --}}
          {!! Form::open(['route' => ['dashboard.advert.destroy',$advert->id],
                          'method' => 'DELETE',
                          'onsubmit' => 'return ConfirmDelete()']) !!}
            <button type="submit" name="btnDelete">Delete</button>
          {!! Form::close() !!}
        @endif
      </li>
    @endforeach
  @else
    <li name="itmNone" class="listItem">
      <h3>No adverts found.</h3>
    </li>
  @endif
@endif
</ul>
