<ul name="listPageItems" data-selectableList="true">
@if (isset($pages))
  @foreach($pages as $page)
    <li data-itemID="{{$page->id}}">
      <a href="{{ URL::route('dashboard.advert.{adID}.page.show', [ $advert->id, $page->id]) }}">
        @if ($selectable == true)
          <input type="checkbox" data-selectableItem="true" name="chkSelectPage_{{ $page->id }}"/>
        @endif
        <label for="chkSelectPage_{{ $page->id }}">{{ $page->PageData->heading }}</label>
      </a>
      @if ($page->deleted == 0)
        <button type="submit" name="btnDisablePage">Disable</button>
      @else
        @if ($user->getAdmin())
          <button type="submit" name="btnEnablePage">Enable</button>
        @endif
      @endif
    </li>
  @endforeach
@endif
</ul>
