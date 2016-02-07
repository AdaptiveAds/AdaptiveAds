<ul class="advertList">
@if (isset($adverts))
  @foreach($adverts as $advert)
    <!-- Only display select if we're adding to a playlist -->
    <li class="advertItem" data-itemID="{{$advert->id}}">
      @if (isset($selectedPlaylist))
          <a href="{{ URL::route('dashboard.playlist.add', [$selectedPlaylist, $advert->id]) }}">{{ $advert->name }}</a>
      @elseif (isset($deleteMode))
          <a href="{{ URL::route('dashboard.playlist.remove', [$playlist->id, $advert->id]) }}">{{ $advert->name }}</a>
      @else
          <a href="{{ URL::route('dashboard.advert.show', $advert->id) }}">{{ $advert->name }}</a>
      @endif
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
