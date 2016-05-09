<ul name="lstPageItems" data-selectableList="true">
@if (isset($pages))
  @if($pages->count() > 0)
    @foreach($pages as $page)
      <li data-itemID="{{$page->id}}" class="listItem" name="{{ $page->PageData->heading }}">

        @if ($selectable == true)
          <input type="checkbox" data-selectableItem="true" name="chkSelectPage_{{ $page->id }}"/>
        @endif
        <label for="chkSelectPage_{{ $page->id }}">{{ $page->PageData->heading }}</label>


        <a href="{{ URL::route('dashboard.advert.{adID}.page.show', [ $advert->id, $page->id]) }}">
          <button type="button" name="btnDesign">Design</button>
        </a>
      </li>
    @endforeach
  @else
    <li name="itmNone" class="listItem">
      <h3>No pages found.</h3>
    </li>
  @endif
@endif
</ul>
