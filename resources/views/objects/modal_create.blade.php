<div id="{{$object or 'object'}}Modal" class="modalDialog">
  <script>
    $('document').ready(function() {
      $("#Close{{$object or 'object'}}Modal").click(function() {
        $(this).trigger('modalClosed');
        history.back(); // Remove the modal from history, Prevents re-opening on back button click
      });
    });
  </script>
  <div>
    <a id="Close{{$object or 'object'}}Modal" href="#close" class="close">X</a>
    <h4>Create new {{$object or 'object'}}</h4>
    {!! Form::open(['route' => $route, 'method' => 'POST']) !!}
      <div class="modalDialogLeft">
        <label>{{$object or 'object'}} Name</label>
        <br/>
        <input type="text" name="txt{{$object or 'object'}}Name" placeholder="Name..."/>
      </div>

      <div class="modalDialogLeft">
        <label>Assign Department</label>
        <br/>
        @include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))
      </div>
      <div class="modalDialogLeft">
        <label>Assign Skin</label>
        <br/>
        @include('objects/dropdown_skins', array('skins' => $skins))
      </div>
      <div class="clear"></div>
      <button type="submit" name="btnAdd{{$object or 'object'}}">Create</button>
    {!! Form::close() !!}
  </div>
</div>
