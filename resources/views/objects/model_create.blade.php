<div id="{{$object or 'object'}}Modal" class="modalDialog">
  <div>
    <a href="#close" class="close">X</a>
    <h4>Create new {{$object or 'object'}}</h4>
    {!! Form::open(['url' => 'dashboard', 'method' => 'GET']) !!}
      <input type="text" name="txt{{$object or 'object'}}Name" placeholder="Name..."/>
      <select name="drpDepartments">
        @foreach ($allowed_departments as $department)
          <option value="{{$department->id}}">{{$department->name}}</option>
        @endforeach
      </select>
      <br/>
      <input type="submit" name="btnCreate{{$object or 'object'}}" value="Create"/>
    {!! Form::close() !!}
  </div>
</div>
