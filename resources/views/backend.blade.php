<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta name="geo.region" 	content="GB" />
	<meta name="geo.placename" 	content="Quedgeley" />
	<meta name="geo.position" 	content="51.8249770;-2.2693960" />
	<meta name="ICBM" 			content="51.8249770, -2.2693960" />
	<meta name="viewport" 		content="width=device-width, initial-scale=1.0, user-scalable=yes"/>

	<link rel="icon" 		href="favicon.ico?v=2" type="image/x-icon" />
	<link rel="home" 		href="/" />
	<link rel="search" 		href="/component/search/" />
	<link rel="help" 		href="/contact-us.htm" />
	<link rel="privacy" 	href="/privacy-policy.htm" />
	<link rel="copyright" 	href="index.php?action=copyright" />
	<link rel="author" 		href="https://plus.google.com/1159196980071151217" />
	<link rel="publisher" 	href="https://plus.google.com/115919698007115121732" />
	<link rel="stylesheet" 	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<!-- preferred plan would be to compile the css from scss prior to uploading using propos -->
	<link rel="stylesheet" 	href="{{ URL::asset('css/default.css') }}" type="text/css">



<!-- requires testing in conjunction with contact form
https://developers.google.com/recaptcha/docs/display -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>

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

		$('li[data-btnTemplate="true"]').click(function() {
			$( '#serve_container, li[data-btnTemplate="true"]' ).removeClass(); // Remove all classes
			$(this).toggleClass('active'); // Toggle active

			$('#serve_container').addClass($(this).data('template'));
			$('input[name="txtTemplate"]').val($(this).data('templateid'));

		});


	});
	</script>

	<script src="{{ URL::asset('js/helpers.js') }}"></script>
	<script src="{{ URL::asset('js/modules.js') }}"></script>
	<script src="{{ URL::asset('js/pages.js') }}"></script>

</head>

<body class="data-swatch-theme-a font-theme-b">
<div id="wrapper">

		<div id="top">
			<div id="fontsizing">
				<ul>
					<li data-btnFont="true" data-theme="font-theme-a" onclick="TextSize.a();"><i class="fa fa-font"></i></li>
					<li data-btnFont="true" data-theme="font-theme-b" onclick="TextSize.b();" class="top-active"><i class="fa fa-font"></i></li>
					<li data-btnFont="true" data-theme="font-theme-c" onclick="TextSize.c();"><i class="fa fa-font"></i></li>
				</ul>
				<div class="clear"></div>
			</div>
			<div id="swatches">
				<ul>
					<li data-btnSwatch="true" data-theme="data-swatch-theme-a" class="top-active"><i class="fa fa-circle-o-notch"></i></li>
					<li data-btnSwatch="true" data-theme="data-swatch-theme-b"><i class="fa fa-circle-o-notch"></i></li>
					<li data-btnSwatch="true" data-theme="data-swatch-theme-c"><i class="fa fa-circle-o-notch"></i></li>
				</ul>
				<div class="clear"></div>
			</div>
			 <div class="clear"></div>
		</div>
		<header id="header">

			<div class="head">
				<div id="logo">
					<a href="{{ URL::to('dashboard')}}"><img src="{{ URL::asset('images/logo.png') }}" alt="php input" title="php input"></a>
				</div>
			</div>
			<div class="head">
				<nav>
					<ul>
						<li><a href="{{ URL::to('dashboard')}}">Home</a></li>
						<li><a href="{{ URL::to('team')}}">Team</a></li>
						<li><a href="{{ URL::to('contact')}}">Contact</a></li>

						<!-- Only show if user is logged in -->
						@if (Auth::guest() == false)
							<li><a name="lnkSignOut" href="{{ URL::to('logout') }}">Sign Out</a></li>
						@else
							<li><a name="lnkSignIn" href="{{ URL::to('login')}}">Sign In</a></li>
						@endif
					</ul>
				</nav>
			</div>
		</header>

	<div id="content">
    @yield('content')
    <div class="clear"></div>
  <!-- close content -->
  </div>
  <footer>
    &copy; <?php echo date('Y'); ?>. AdaptiveAds. All Rights Reserved.
  </footer>
<!-- close wrapper -->
  </div>
</body>
</html>
