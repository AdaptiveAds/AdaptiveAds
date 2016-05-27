<select name="drpSchedules">
  <option selected>Select a Schedule</option>
  @foreach ($schedules as $schedule)
    <option value="{{$schedule->id}}">{{$schedule->name}}</option>
  @endforeach
</select>
