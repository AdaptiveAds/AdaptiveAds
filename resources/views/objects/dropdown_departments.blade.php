<select name="drpDepartments">
  @foreach ($allowed_departments as $department)
    <option value="{{$department->id}}">{{$department->name}}</option>
  @endforeach
</select>
