<ul data-selectableList="true" name="lstAdvertItems">
@if (isset($adverts))
  @if($adverts->count() > 0)
    @foreach($adverts as $advert)
      <!-- Only display select if we're adding to a playlist -->
      <li data-itemID="{{$advert->id}}">
        @if (isset($deleteMode))
            <a href="{{ URL::route('dashboard.playlist.remove', [$playlist->id, $advert->id]) }}">
        @else
            <a href="{{ URL::route('dashboard.advert.edit', $advert->id) }}">
        @endif

          @if ($selectable == true)
            <input type="checkbox" data-selectableItem="true" name="chkSelectAdvert_{{ $advert->id }}"/>
          @endif
          <label for="chkSelectAdvert_">{{ $advert->name }}</label>
        </a>

        <a href="#AdvertModal" data-displayEditModal="true"
                               data-modalObject="Advert"
                               data-modalMethod="PUT"
                               data-modalRoute="{{ URL::route('dashboard.advert.update', $advert->id) }}"
                               data-userID="{{ $advert->id }}">
          <button type="button" name="btnEdit">Edit</button>
        </a>
        @if ($advert->deleted == 0)
          <button type="submit" name="btnDisable">Disable</button>
        @else
          @if ($user->getAdmin())
            <button type="submit" name="btnEnable">Enable</button>
          @endif
        @endif
      </li>
    @endforeach
  @else
    <li name="itmNone">
      <h3>No adverts found.</h3>
    </li>
  @endif
@endif
</ul>
