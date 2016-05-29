<!-- <<<<<<< HEAD-->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!--=======
 @include('pages/header')
>>>>>>> origin/master-->


<head>
	<title>AdaptiveAds</title>

	<link rel="stylesheet" 	href="{{ URL::asset('fonts/font-awesome-4.5.0/css/font-awesome.min.css') }}">

<!-- preferred plan would be to compile the css from scss prior to uploading using propos -->
	<link rel="stylesheet" 	href="{{ URL::asset('css/frontend.css') }}" type="text/css">

	<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>
	<script src="{{ URL::asset('js/mobilemenu.js') }}"></script>

@include('pages\headJavascript')

</head>

<body class="data-swatch-theme-a font-theme-b">
<div id="wrapper">

@include('pages\header')

			<!-- ************************** -->
		  <!--          ROW | ONE         -->
		  <!-- ************************** -->
			<!-- *THIS WILL BE THE BANNER* -->
		  <div class="row one">
		    <div class="wrapper">
		      <div id="bannerText">
		        <div id="right">
		        </div>
		        <div class="clear"></div>
		      </div>
		    </div>
		  </div>
		  <!-- ************************** -->
		  <!--          ROW | TWO         -->
		  <!-- ************************** -->
			<!-- *THIS WILL BE THE CONTENT* -->
		  <div class="row two">
					<div id="content">
				    @yield('content')

						<div id="featured">
							<div class="trio">
								<div class="icon"><img src="{{ URL::asset('images/logo.png') }}" alt="#" title="#"></div>
								<div class="icon-text"><span>Title</span></div>
							</div>
							<div class="trio">
								<div class="icon"><img src="{{ URL::asset('images/logo.png') }}" alt="#" title="#"></div>
								<div class="icon-text"><span>Title</span></div>
							</div>
							<div class="trio">
								<div class="icon"><img src="{{ URL::asset('images/logo.png') }}" alt="#" title="#"></div>
								<div class="icon-text"><span>Title</span></div>
							</div>
						</div>

				  <!-- close content -->
					<div class="clear"></div>
				  </div>
		    <div class="clear"></div>
		  </div>


	<!-- ************************** -->
  <!--         ROW | THREE        -->
  <!-- ************************** -->
	<!-- THIS WILL BE THE VIDEO -->
  <div class="row three">
    <div class="wrapper">
    <div class="left">
			<div class="newsflash">
				<h3 class="newsflash-title">Video Blurb</h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
			</div>
    </div>
    <div class="right">
      <iframe src="https://www.youtube.com/embed/ubZASS3uPrs?rel=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
    </div>
    <div class="clear"></div>
  </div>
</div>
<!-- ************************** -->
<!--         ROW | FOUR         -->
<!-- ************************** -->
<!-- THIS WILL BE THE OVERVIEW -->
<div class="row four">
  <div class="wrapper">
		<div id="servicesIntro">
			<h2>Services</h2>
			<p>Centered text which will provide an overview of the services / classes that meta physique will offer its clients.</p>
		</div>
			<div id="servicesMain">
				<div class="service"><img title="placeholder" src="images/placeholder.png" alt="placeholder" />
					<h3>This is a title</h3>
					<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>

				</div>
				<div class="service"><img title="placeholder" src="images/placeholder.png" alt="placeholder" />
					<h3>This is a title</h3>
					<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
				</div>

				<div class="service"><img title="placeholder" src="images/placeholder.png" alt="placeholder" />
					<h3>This is a title</h3>
					<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>

				</div>
				<div class="service"><img title="placeholder" src="images/placeholder.png" alt="placeholder" />
					<h3>This is a title</h3>
					<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>

				</div>
			</div>
    <div class="clear"></div>
  </div>
</div>
<!-- ************************** -->
<!--         ROW | FIVE         -->
<!-- ************************** -->
<!-- THIS WILL BE THE GALLERY + UPDATES SIGNUP
<div class="row five">
  <div class="wrapper">
    <div class="left">
      <jdoc:include type="modules" name="social-gallery"/>
    </div>
    <div class="right">
			<form>
					<h3>Newsletter Signup</h3>
					<p>short explanation as to why clients should sign up. short explanation as to why clients should sign up.</p>
					<ul>
						<li>Up to date Nutrician Advice</li>
						<li>The latest fitness techniques</li>
						<li>Seasonable offers</li>
						<li>Up to date Nutrician Advice</li>
						<li>The latest fitness techniques</li>
						<li>Seasonable offers</li>
						<li>Up to date Nutrician Advice</li>
						<li>The latest fitness techniques</li>
						<li>Seasonable offers</li>
					</ul>
					<label>Name</label>
					<input></input>
					<label>Email</label>
					<input></input>
					<button class="btn-submit">Submit</button>
				</form>
    </div>
    <div class="clear"></div>
  </div>
</div>-->
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
