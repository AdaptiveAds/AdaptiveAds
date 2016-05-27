<select name="drpDepartments">
  <option selected>Select a Department</option>
  @foreach ($allowed_departments as $department)
    @if (Session::has('remember_id'))
      @if (Session::get('remember_id') == $department->id)
        <option value="{{$department->id}}" selected="selected">{{$department->name}}</option>
      @else
        <option value="{{$department->id}}">{{$department->name}}</option>
      @endif
    @else
      <option value="{{$department->id}}">{{$department->name}}</option>
    @endif
  @endforeach
</select>
