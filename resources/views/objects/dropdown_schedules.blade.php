<select name="drpSchedules">
  @foreach ($schedules as $schedule)
    <option value="{{$schedule->id}}">{{$schedule->name}}</option>
  @endforeach
</select>
