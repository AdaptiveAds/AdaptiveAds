<select name="drpPrivileges">
  @foreach ($privileges as $privilege)
    <option value="{{$privilege->id}}">{{$privilege->name}}</option>
  @endforeach
</select>
