@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST', 'files' => 'true']) !!}
    <ul>
      <li>
        <label>Template Name:</label>
        <input type="text" name="txtSkinName" placeholder="Skin Name...."/>
      </li>
      <li>
        <label>Class Name:</label>
        <input type="text" name="txtSkinClass" placeholder="Skin Class...."/>
      </li>
      <li>
        <button type="submit" name="btnSave">Save</button>
      </li>
    </ul>
  {!! Form::close() !!}
</div>
@endsection
