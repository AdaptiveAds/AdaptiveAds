<ul data-selectableList="true">
@if (isset($pages))
  @foreach($pages as $page)
    <li data-selectableItem="true" data-itemID="{{$page->id}}">
      <input type="checkbox"/>
      <a href="{{ URL::route('dashboard.advert.{adID}.page.show', [ $advert->id, $page->id]) }}">
        {{ $page->PageData->heading }}
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
