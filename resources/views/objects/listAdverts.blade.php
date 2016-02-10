<ul data-selectableList="true" name="lstAdvertItems">
@if (isset($adverts))
  @if($adverts->count() > 0)
    @foreach($adverts as $advert)
      <!-- Only display select if we're adding to a playlist -->
      <li data-itemID="{{$advert->id}}">
        @if (isset($selectedPlaylist))
            <a href="{{ URL::route('dashboard.playlist.add', [$selectedPlaylist, $advert->id]) }}">
        @elseif (isset($deleteMode))
            <a href="{{ URL::route('dashboard.playlist.remove', [$playlist->id, $advert->id]) }}">
        @else
            <a href="{{ URL::route('dashboard.advert.show', $advert->id) }}">
        @endif

          @if ($selectable == true)
            <input type="checkbox" data-selectableItem="true" name="chkSelectAdvert_{{ $advert->id }}"/>
          @endif
          <label for="chkSelectAdvert_">{{ $advert->name }}</label>
        </a>

        <button type="submit" name="btnEdit">Edit</button>
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
