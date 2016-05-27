<select name="drpPrivileges">
  <option selected>Select a Privilege</option>
  @foreach ($privileges as $privilege)
    <option value="{{$privilege->id}}">{{$privilege->name}}</option>
  @endforeach
</select>
