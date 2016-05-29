<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>AdaptiveAds</title>

	<link rel="stylesheet" 	href="{{ URL::asset('fonts/font-awesome-4.5.0/css/font-awesome.min.css') }}">

<!-- preferred plan would be to compile the css from scss prior to uploading using propos -->
	<link rel="stylesheet" 	href="{{ URL::asset('css/default.css') }}" type="text/css">

	<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>
	<script src="{{ URL::asset('js/colorpicker.js') }}"></script>
	<script src="{{ URL::asset('js/inputdelete.js') }}"></script>
	<script src="{{ URL::asset('js/mobilemenu.js') }}"></script>

	<script type="text/javascript">
	$('document').ready(function(){
		var theme = localStorage.getItem('currentTheme');
		var font = localStorage.getItem('currentFont');

		if (theme !== null) {
			$('body').removeClass();
			$('body').addClass(theme);

				$('li[data-btnSwatch="true"]').removeClass();
				$('li[data-btnSwatch="true"]').each(function() {
					if ($(this).data('theme') == theme) {
						$(this).addClass('top-active');
					}
				});
		}

		if (font !== null) {
			$('body').addClass(font);

			$('li[data-btnFont="true"]').removeClass();
			$('li[data-btnFont="true"]').each(function() {
				if ($(this).data('theme') == font) {
					$(this).addClass('top-active');
				}
			});
		}

		$('.btn-orientationHor').click(function() {
			// Writing the code like this will allow SCSS to be added to the button to show which is active
			$('#left').removeClass('portrait');
			$('#left').addClass('landscape');
			$('.btn-orientationHor').addClass('active');
			$('.btn-orientationVert').removeClass('active');
		});
		$('.btn-orientationVert').click(function() {
			$('#left').removeClass('landscape');
			$('#left').addClass('portrait');
			$('.btn-orientationHor').removeClass('active');
			$('.btn-orientationVert').addClass('active');
		});

		$('li[data-btnSwatch="true"], li[data-btnFont="true"]').click(function() {
			$( 'body' ).removeClass(); // Remove all classes
		  $( this ).parent().children().removeClass('top-active'); // Remove active from all children
		  $( this ).toggleClass('top-active'); // Toggle active

		  // Foreach active element add the theme data to the body class
		  $('.top-active').each(function() {
		  	$( 'body' ).addClass($(this).data('theme'));

				if ($(this).data('btnswatch') !== undefined) {
					localStorage.setItem('currentTheme',$(this).data('theme'));
				}

				if ($(this).data('btnfont') !== undefined) {
					localStorage.setItem('currentFont',$(this).data('theme'));
				}
		  });
		});
		$('.menu').on('click', function(e){
		   $(this).toggleClass('active');
		   $(this).siblings('.fullscreen-menu').toggleClass('active');
		});

	});
	</script>
	<script>
		$(document).ready(function(){
			$(".nav-button").click(function () {
			$(".nav-button,.primary-nav").toggleClass("open");
			});
		});
	</script>

	<script src="{{ URL::asset('js/helpers.js') }}"></script>
	<script src="{{ URL::asset('js/modules.js') }}"></script>
	<script src="{{ URL::asset('js/pages.js') }}"></script>

</head>
