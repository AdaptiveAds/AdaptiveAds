@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST', 'name' => '$object + ModalForm']) !!}
    <ul>
      <li>
        <label>Advert Name:</label>
        <input type="text" name="txtAdvertName" placeholder="Advert Name...."/>
      </li>
      <li>
        <label>Department:</label>
        @include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))
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
