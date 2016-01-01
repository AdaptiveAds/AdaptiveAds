<ul class="pageList">
@if (isset($pages))
  @foreach($pages as $page)
    <li class="advertItem">
      <a href="{{ URL::to('dashboard/advert/' . $advert->id . '/page/' . $page->id) }}">{{ $page->PageData->page_data_name }}</a>
    </li>
  @endforeach
@endif
</ul>
