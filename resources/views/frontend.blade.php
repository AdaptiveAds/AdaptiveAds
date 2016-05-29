<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>AdaptiveAds</title>

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
	<link rel="stylesheet" 	href="{{ URL::asset('css/frontend.css') }}" type="text/css">

  <!-- KW 1.01.16 requires testing in conjunction with contact form
  https://developers.google.com/recaptcha/docs/display
  	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
   -->

	<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>
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

<body class="data-swatch-theme-a font-theme-b">
<div id="wrapper">

		<div id="top">
			<div id="fontsizing">
				<ul>
					<li title="Small Fonts"  data-btnFont="true" data-theme="font-theme-a" onclick="TextSize.a();"><i class="fa fa-font"></i></li>
					<li title="Medium Fonts"  data-btnFont="true" data-theme="font-theme-b" onclick="TextSize.b();" class="top-active"><i class="fa fa-font"></i></li>
					<li title="Large Fonts" data-btnFont="true" data-theme="font-theme-c" onclick="TextSize.c();"><i class="fa fa-font"></i></li>
				</ul>
				<div class="clear"></div>
			</div>

			<div id="swatches">
				<ul>
					<li title="Light Theme" data-btnSwatch="true" data-theme="data-swatch-theme-a" class="top-active"><i class="fa fa-circle-o-notch"></i></li>
					<li title="Neutral Theme"  data-btnSwatch="true" data-theme="data-swatch-theme-b"><i class="fa fa-circle-o-notch"></i></li>
					<li title="Dark Theme"  data-btnSwatch="true" data-theme="data-swatch-theme-c"><i class="fa fa-circle-o-notch"></i></li>
				</ul>
				<div class="clear"></div>
			</div>
			<div id="mainmenu-btn">
				@if (Auth::guest() == false)
					<a title="Logout" name="lnkSignOut" href="{{ URL::to('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
				@else
					<a title="Login" name="lnkSignIn" href="{{ URL::to('login')}}"><i class="fa fa-sign-in" aria-hidden="true"></i></a>
				@endif

				@if (Auth::guest() == false)
					<a  title="Return Home" name="lnkHome" href="{{ URL::to('dashboard')}}"><i class="fa fa-home" aria-hidden="true"></i></a>
				@else
					<a  title="Return Home" name="lnkDashboard" href="{{ URL::to('home')}}"><i class="fa fa-home" aria-hidden="true"></i></a>
				@endif
				<button  title="Menu"  name="mainmenu-btn" class="nav-button">Menu</button>

			</div>
		  <div class="clear"></div>

		</div>

		<header id="header">
			<nav>
					<ul class="primary-nav">
						@if (Auth::guest() == false)
							<li><a name="lnkHome" href="{{ URL::to('dashboard')}}">Home</a></li>
						@else
							<li><a name="lnkDashboard" href="{{ URL::to('home')}}">Home</a></li>
						@endif
						@if (Auth::guest() == false)
							<li><a name="lnkFAQ" href="{{ URL::to('FAQ') }}">FAQ</a></li>
						@else
							<li class="parent"><a name="lnkTeam" href="{{ URL::to('team')}}">Team</a></li>
								<ul>
									<li><a name="lnkTeam" href="{{ URL::to('about')}}">About</a></li>
								</ul>
						@endif
						<!-- Only show if user is logged in -->
						@if (Auth::guest() == false)
							<li><a name="lnkSupport" href="mailto:kanewhelan@glos.ac.uk?Subject=AdaptiveAds%20Support">Support</a></li>
						@else
							<li><a name="lnkContact" href="{{ URL::to('login')}}">Contact</a></li>
						@endif
						<!-- Only show if user is logged in -->
						@if (Auth::guest() == false)
							<li><a name="lnkSignOut" href="{{ URL::to('logout') }}">Sign Out</a></li>
						@else
							<li><a name="lnkSignIn" href="{{ URL::to('login')}}">Sign In</a></li>
						@endif
					</ul>
				</nav>
			</header>


	<div id="content">
    @yield('content')

  <!-- close content -->
	<div class="clear"></div>
  </div>
	<footer>
		<!-- if logged in -->
		@if (Auth::guest() == false)
			&copy; <?php echo date('Y'); ?>. <a href="http://www.glos.ac.uk/" target="_window">University of Gloucestershire</a>. All Rights Reserved.
		@else
		<!-- if logged out -->
			&copy; <?php echo date('Y'); ?>. <a href="http://www.adaptiveads.uk">AdaptiveAds</a>. All Rights Reserved.
		@endif

  </footer>

<!-- close wrapper -->
<div class="clear"></div>
</div>
</body>
</html>
