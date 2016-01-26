<ul class="advertList">
@if (isset($adverts))
  @foreach($adverts as $advert)
    <!-- Only display select if we're adding to a playlist -->
    @if (isset($selectedPlaylist))
      <li class="advertItem" data-itemID="{{$advert->id}}"><a href="{{ URL::route('dashboard.playlist.add', [$selectedPlaylist, $advert->id]) }}">{{ $advert->name }}</a></li>
    @elseif (isset($deleteMode))
      <li class="advertItem" data-itemID="{{$advert->id}}"><a href="{{ URL::route('dashboard.playlist.remove', [$playlist->id, $advert->id]) }}">{{ $advert->name }}</a></li>
    @else
      <li class="advertItem" data-itemID="{{$advert->id}}"><a href="{{ URL::route('dashboard.advert.show', $advert->id) }}">{{ $advert->name }}</a></li>
    @endif
  @endforeach
@endif
</ul>
