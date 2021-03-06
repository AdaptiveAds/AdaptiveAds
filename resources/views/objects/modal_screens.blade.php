@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST', 'files' => 'true', 'name' => '$object + ModalForm']) !!}
    <ul>
      <li>
        <label>Screen ID:</label>
        <input type="text" name="txtScreenID" disabled/>
      </li>
      <li>
        <label>Location:</label>
        @include('objects/dropdown_locations', array('locations' => $locations))
      </li>
      <li>
        <button type="submit" name="btnSave">Save</button>
      </li>
    </ul>
  {!! Form::close() !!}
</div>
@endsection
