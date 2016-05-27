<select name="drpLocations">
  <option select>Select a Location</option>
  @foreach ($locations as $location)
    <option value="{{$location->id}}">{{$location->name}}</option>
  @endforeach
</select>
