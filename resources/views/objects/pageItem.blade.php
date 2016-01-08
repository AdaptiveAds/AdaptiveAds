<ul class="pageList">
@if (isset($pages))
  @foreach($pages as $page)
    <li class="advertItem">
      <a href="{{ URL::route('dashboard.advert.{adID}.page.show', [ $advert->id, $page->id]) }}">{{ $page->PageData->page_data_name }}</a>
    </li>
  @endforeach
@endif
</ul>
