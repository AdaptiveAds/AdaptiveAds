@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST', 'name' => '$object + ModalForm']) !!}
    <ul>
      <li>
        <label>Playlist Name:</label>
        <input type="text" name="txtPlaylistName" placeholder="Playlist Name...."/>
      </li>
      <li>
        <label>Department:</label>
        @include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))
      </li>
      @if (isset($user))
        @if ($user->is_super_user)
          <li>
            <label for="chkIsGlobal">Is Global:</label>
            <input type="checkbox" name="chkIsGlobal" disabled/>
          </li>
        @endif
      @endif
      <li>
        <button type="submit" name="btnSave">Save</button>
      </li>
    </ul>
  {!! Form::close() !!}
</div>
@endsection
