<div id="{{$object or 'object'}}Modal" class="modalDialog">
  <script>
    $('document').ready(function() {
      $('#{{$object or 'object'}}Modal .close').click(function() {
        $(this).trigger('modalClosed');
        history.back(); // Remove the modal from history, Prevents re-opening on back button click
      });
    });
  </script>
  <div>
    <a href="#close" class="close fa fa-times"></a>
    <div class="loading hidden">
      <!-- image from: http://preloaders.net/en/circular/2 -->
      <img src="{{ URL::asset('images/loading.gif') }}"/>
      <h3>Please wait....</h3>
    </div>
    <div class="errors hidden">
      <h3>Error</h3>
      <p name="errorMsg"></p>
    </div>
    @yield('modal_content')
  </div>
</div>
