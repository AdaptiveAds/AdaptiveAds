<ul data-selectableList="true">
@if (isset($pages))
  @foreach($pages as $page)
    <li data-selectableItem="true" data-itemID="{{$page->id}}">
      <a href="{{ URL::route('dashboard.advert.{adID}.page.show', [ $advert->id, $page->id]) }}">{{ $page->PageData->heading }}</a>
    </li>
  @endforeach
@endif
</ul>
