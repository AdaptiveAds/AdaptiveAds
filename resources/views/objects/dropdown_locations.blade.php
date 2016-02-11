<select name="drpLocations">
  @foreach ($locations as $location)
    <option value="{{$location->id}}">{{$location->name}}</option>
  @endforeach
</select>
