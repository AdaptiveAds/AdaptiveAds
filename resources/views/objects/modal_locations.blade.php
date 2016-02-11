@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST']) !!}
    <ul>
      <li>
        <label>Location Name:</label>
        <input type="text" name="txtLocationName" placeholder="Location Name...."/>
      </li>
      <li>
        <label>Department:</label>
        @include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))
      </li>
      <li>
        <button type="submit" name="btnSave">Save</button>
      </li>
    </ul>
  {!! Form::close() !!}
</div>
@endsection
