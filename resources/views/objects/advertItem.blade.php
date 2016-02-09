<ul data-selectableList="true" name="lstAdvertItems">
@if (isset($adverts))
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

        <input type="checkbox" data-selectableItem="true" name="chkSelectAdvert_{{ $advert->id }}"/>
        <label for="chkSelectAdvert_">{{ $advert->name }}</label>
      </a>

      <button type="submit" name="btnEditAdvert">Edit</button>
      @if ($advert->deleted == 0)
        <button type="submit" name="btnDisableAdvert">Disable</button>
      @else
        @if ($user->getAdmin())
          <button type="submit" name="btnEnableAdvert">Enable</button>
        @endif
      @endif
    </li>
  @endforeach
@endif
</ul>
