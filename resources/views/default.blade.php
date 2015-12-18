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

	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript">
	$('document').ready(function(){
		$('.btn-orientationHor').click(function() {
		$('#left').removeClass('portrait');
		$('#left').addClass('landscape');
		});
		$('.btn-orientationVert').click(function() {
		$('#left').removeClass('landscape');
		$('#left').addClass('portrait');
		});
	});
	</script>

</head>

<body id="{{ $pageName }}">
<div id="wrapper">
		<header id="header">
			<!-- IF statement for anchor: If the user has not logged in, prompt for login before accessing the dashboard -->
			<div class="head">
				<a href="../index.php?action=dashboard"><img src="{{ URL::asset('images/logo.png') }}" alt="php input" title="php input"></a>
			</div>
			<div class="head">
				<nav>
					<ul>
						<li><a href="../index.php?action=dashboard"><i class="fa fa-home"></i></a></li>
						<li><a href="../index.php?action=team"><i class="fa fa-users"></i></a></li>
						<li><a href="../index.php?action=contact"><i class="fa fa-envelope"></i></a></li>
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
