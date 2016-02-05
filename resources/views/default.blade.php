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
	});
	</script>

	<script src="{{ URL::asset('js/modules.js') }}"></script>
	<script src="{{ URL::asset('js/pages.js') }}"></script>

</head>

<body>
<div id="wrapper">
	<!-- Only show if user is logged in -->
	@if (Auth::guest() == false)
		<div id="signedin">Signed in: <span id="signinName">{{Auth::user()->username}}</span> <a href="{{ URL::to('auth/logout') }}"><button id="signout" class="button-active">Sign out</button></a></div>
	@endif
<!--
	<div id="themeColor">
		<ul>
			<li><i class="fa fa-circle-o-notch"></i></li>
			<li><i class="fa fa-circle-o-notch"></i></li>
			<li><i class="fa fa-circle-o-notch"></i></li>
			<li><i class="fa fa-circle-o-notch"></i></li>
			<li><i class="fa fa-circle-o-notch"></i></li>
			<li><i class="fa fa-circle-o-notch"></i></li>
			<li><i class="fa fa-circle-o-notch"></i></li>
			<li><i class="fa fa-circle-o-notch"></i></li>
		</ul>
	</div>
-->
		<header id="header">
			<div class="head">
				<a href="{{ URL::to('dashboard')}}"><img src="{{ URL::asset('images/logo.png') }}" alt="php input" title="php input"></a>
			</div>
			<div class="head">
				<nav>
					<ul>
						<li><a href="{{ URL::to('dashboard')}}"><i class="fa fa-home"></i></a></li>
						<li><a href="{{ URL::to('team')}}"><i class="fa fa-users"></i></a></li>
						<li><a href="{{ URL::to('contact')}}"><i class="fa fa-envelope"></i></a></li>
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
