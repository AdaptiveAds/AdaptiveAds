@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST', 'files' => 'true']) !!}
    <ul>
      <li>
        <label>Template Name:</label>
        <input type="text" name="txtTemplateName" placeholder="Template Name...."/>
      </li>
      <li>
        <label>Class Name:</label>
        <input type="text" name="txtTemplateClass" placeholder="Template Class...."/>
      </li>
      <li>
        <label>Display Duration:</label>
        <input type="number" name="numTemplateDuration" placeholder="Duration (Seconds)...."/>
      </li>
      <li>
        <label>Thumbnail:</label>
        <input type="file" name="filTemplateThumbnail"/>
      </li>
      <li>
        <button type="submit" name="btnSave">Save</button>
      </li>
    </ul>
  {!! Form::close() !!}
</div>
@endsection
