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
        	$('input[name="hexSkinColor"]').val(hex);
        }
      });
    });
  </script>
  <h4 name='heading'>{{$heading or 'Modal Purpose'}}</h4>
  {!! Form::open(['url' => '', 'method' => 'POST', 'files' => 'true', 'name' => '$object + ModalForm']) !!}
    <ul>
      <li>
        <label>Skin Name:</label>
        <input type="text" name="txtSkinName" placeholder="Skin Name...."/>
      </li>
      <li>
        <label>Skin Image:</label>
        <input type="file" name="filSkinImage" accept="image/*"/>
      </li>
      <li>
        <label>Skin Colour:</label>
        <input type="hidden" name="hexSkinColor"/>
        <div id="colorSelector2">
          <div style="background-color: rgb(61, 61, 219);"></div>
        </div>
      </li>
        <button type="submit" name="btnSave">Save</button>
      </li>
    </ul>
  {!! Form::close() !!}
</div>
@endsection
