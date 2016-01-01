<ul class="advertList">
@if (isset($adverts))
  @foreach($adverts as $advert)
    <li class="advertItem"><a href="{{ URL::to('dashboard/advert/' . $advert->id)}}">{{ $advert->advert_name }}</a></li>
  @endforeach
@endif
</ul>
