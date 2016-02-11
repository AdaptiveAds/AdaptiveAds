@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST', 'files' => 'true']) !!}
    <ul>
      <li>
        <label>Department Name:</label>
        <input type="text" name="txtDepartmentName" placeholder="Department Name...."/>
      </li>
      <li>
        <label>Skin:</label>
        @include('objects/dropdown_skins', array('skins' => $skins))
      </li>
      <li>
        <button type="submit" name="btnSave">Save</button>
      </li>
    </ul>
  {!! Form::close() !!}
</div>
@endsection
