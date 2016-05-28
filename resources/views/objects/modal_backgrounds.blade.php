@extends('objects/modal')

@section('modal_content')
<div class="modal_content">
  <script>
    $('document').ready(function() {
      $('#colorSelector2').ColorPicker({
        color: '#0000ff',
        onShow: function (colpkr) {
        	$(colpkr).fadeIn(500);
        	return false;
        },
        onHide: function (colpkr) {
        	$(colpkr).fadeOut(500);
        	return false;
        },
        onChange: function (hsb, hex, rgb) {
        	$('#colorSelector2 div').css('backgroundColor', '#' + hex);
        	$('input[name="hexBackgroundColor"]').val(hex);
        }
      });
    });
  </script>
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST', 'files' => 'true', 'name' => '$object + ModalForm']) !!}
    <ul>
      <li>
        <label>Background Name:</label>
        <input type="text" name="txtBackgroundName" placeholder="Background Name...."/>
      </li>
      <li>
        <label>Background Image:</label>
        <input type="file" name="filBackgroundImage" accept="image/*"/>
      </li>
      <li>
        <label>Background Colour:</label>
        <input type="hidden" name="hexBackgroundColor"/>
        <div id="colorSelector2">
          <div style="background-color: rgb(61, 61, 219);"></div>
        </div>
        <button type="submit" name="btnRemoveColour">Remove Background Colour</button>
      </li>
        <button type="submit" name="btnSave">Save</button>
      </li>
    </ul>
  {!! Form::close() !!}
</div>
@endsection
