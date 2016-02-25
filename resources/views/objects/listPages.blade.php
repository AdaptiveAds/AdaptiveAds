<ul name="lstPageItems" data-selectableList="true">
@if (isset($pages))
  @if($pages->count() > 0)
    @foreach($pages as $page)
      <li data-itemID="{{$page->id}}">
        <a href="{{ URL::route('dashboard.advert.{adID}.page.show', [ $advert->id, $page->id]) }}">
          @if ($selectable == true)
            <input type="checkbox" data-selectableItem="true" name="chkSelectPage_{{ $page->id }}"/>
          @endif
          <label for="chkSelectPage_{{ $page->id }}">{{ $page->PageData->heading }}</label>
        </a>
      </li>
    @endforeach
  @else
    <li name="itmNone">
      <h3>No pages found.</h3>
    </li>
  @endif
@endif
</ul>
