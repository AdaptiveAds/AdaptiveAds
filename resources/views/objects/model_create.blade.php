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
        <select name="drpDepartments">
          @foreach ($allowed_departments as $department)
            <option value="{{$department->id}}">{{$department->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="clear"></div>
      <input type="submit" class="submit" name="btnCreate{{$object or 'object'}}" value="Create"/>
    {!! Form::close() !!}
  </div>
</div>
