<div id="DeleteModal" class="modalDialog">
  <script>
    $('document').ready(function() {
      $('[name="close"]').click(function() {
        $(this).trigger('modalClosed');
        history.back(); // Remove the modal from history, Prevents re-opening on back button click
      });
    });
  </script>
  <div>
    <a href="#close" name="close" class="close fa fa-times"></a>
    <div class="loading hidden">
      <!-- image from: http://preloaders.net/en/circular/2 -->
      <img src="{{ URL::asset('images/loading.gif') }}"/>
      <h3>Please wait....</h3>
    </div>
    <div class="errors hidden">
      <h3>Error</h3>
      <p name="errorMsg"></p>
    </div>
    <div class="modal_content">
      {!! Form::open(['url' => '', 'method' => 'POST', 'name' => 'DeleteModalForm']) !!}
        <ul>
          <li>
            <h2>Confirm delete?</h2>
          </li>
          <li>
            <button type="submit" name="btnSave">Delete</button>
            <a href="#close" name="close"><button type="button" name="btnCancel">Cancel</button></a>
          </li>
        </ul>
      {!! Form::close() !!}
    </div>
  </div>
</div>
