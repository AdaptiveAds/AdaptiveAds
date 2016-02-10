<div id="{{$object or 'object'}}Modal" class="modalDialog">
  <div>
    <a href="#close" class="close">X</a>
    <div class="loading hidden">
      <!-- image from: http://preloaders.net/en/circular/2 -->
      <img src="{{ URL::asset('images/loading.gif') }}"/>
      <h3>Please wait....</h3>
    </div>
    <div class="errors hidden">
      <h3>Error</h3>
      <p name="errorMsg"></p>
    </div>
    @yield('modal_errors')
    @yield('modal_content')
  </div>
</div>
