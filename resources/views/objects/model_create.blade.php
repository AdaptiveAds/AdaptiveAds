<div id="{{$object or 'object'}}Modal" class="modalDialog">
  <div>
    <a href="#close" class="close">X</a>
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
        @include('objects/departments_dropdown', array('allowed_departments' => $allowed_departments))
      </div>
      <div class="clear"></div>
      <button type="submit" name="btnAdd{{$object or 'object'}}">Create</button>
    {!! Form::close() !!}
  </div>
</div>
