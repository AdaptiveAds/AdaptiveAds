<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>AdaptiveAds</title>

	<link rel="stylesheet" 	href="{{ URL::asset('fonts/font-awesome-4.5.0/css/font-awesome.min.css') }}">

<!-- preferred plan would be to compile the css from scss prior to uploading using propos -->
	<link rel="stylesheet" 	href="{{ URL::asset('css/frontend.css') }}" type="text/css">

	<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>
	<script src="{{ URL::asset('js/mobilemenu.js') }}"></script>

@include('pages/headJavascript')

</head>

<body class="data-swatch-theme-a font-theme-b">
<div id="wrapper">

@include('pages/header')

			<!-- ************************** -->
		  <!--          ROW | ONE         -->
		  <!-- ************************** -->
			<!-- *THIS WILL BE THE BANNER* -->
		  <div class="row one">
		    <div class="wrapper">
		      <div id="teaser">
						<video  controls autoplay muted>
							<source src="{{ URL::asset('advert_videos/adaptive.mp4') }}" type="video/mp4">
							<source src="{{ URL::asset('advert_videos/adaptive.ogg') }}" type="video/ogg">
						   Your browser does not support the video tag.
						</video>
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

						<ul>
							<li>
								<img src="{{ URL::asset('images/icons/dashboardAdvertAdd.png') }}" alt="Desgin Adverts" title="Design Adverts">
								<span>Design Adverts</span>
							</li>
							<li>
								<img src="{{ URL::asset('images/icons/dashboardScreens.png') }}" alt="Multiple Screens" title="Multiple Screens">
								<span>Manage Screens</span>
							</li>
							<li>
								<img src="{{ URL::asset('images/icons/dashboardLocations.png') }}" alt="Manage Locations" title="Manage Locations">
								<span>Multiple Locations</span>
							</li>

				  <!-- close content -->
					<div class="clear"></div>
				  </div>
		  </div>


	<!-- ************************** -->
  <!--         ROW | THREE        -->
  <!-- ************************** -->
	<!-- THIS WILL BE THE VIDEO -->
  <div class="row three">
    <div class="wrapper">
    <div class="left">
				<h3>University of Gloucestershire - School of Computing</h3>
				<p>Many of our students do work placements within industry. Some of our recent students have worked with top names such as Accenture, Hewlett Packard, Fujitsu, GE Capital and Renishaw. Placements give you the chance to become familiar with professional industry processes and build contacts for the future..</p>
			</div>
    </div>
    <div class="right">
			<video controls preload="none">
				<source src="{{ URL::asset('advert_videos/computing.mp4') }}" type="video/mp4">
				<source src="{{ URL::asset('advert_videos/computing.ogg') }}" type="video/ogg">
				 Your browser does not support the video tag.
			</video>
    </div>
    <div class="clear"></div>
  </div>
<!-- ************************** -->
<!--         ROW | FOUR         -->
<!-- ************************** -->
<!-- THIS WILL BE THE OVERVIEW -->
<div class="row four">
  <div class="wrapper">
		<div id="servicesIntro">
			<h2>Why AdaptiveAds?</h2>
			<p>The AdaptiveAds team are regular guys offering their services to better improve your business advertising for FREE. Need we say more? Okay, if you want more - check out below!</p>
		</div>
			<div id="servicesMain">
				<div class="service">
					<a name="lnkTeam" href="{{ URL::to('team')}}">
						<img title="placeholder" src="{{ URL::asset('images/frontend/open-source.png') }}" alt="Open Source" title="Open Source System"/>
						<h3>What do you mean FREE?</h3>
						<p>The open-source MIT license permits both personal and commercial use provided you include a copy of the MIT License terms and the copyright notice.
						</p>
					</a>
				</div>

				<div class="service">
					<a name="lnkTeam" href="{{ URL::to('team')}}">
						<img title="placeholder" src="{{ URL::asset('images/frontend/team.png') }}" alt="Team" title="Team" />
						<h3>Development Team</h3>
						<p>Technology creates opportunity, it is our choice to seize these opportunities...</p>
					</a>
				</div>

				<div class="service">
					<a name="lnkTeam" href="{{ URL::to('team')}}">
						<img title="placeholder" src="{{ URL::asset('images/frontend/placeholder.png') }}" alt="placeholder" />
						<h3>Development Team</h3>
						<p></p>
					</a>
				</div>

				<div class="service">
					<a name="lnkTeam" href="{{ URL::to('team')}}">
						<img title="placeholder" src="{{ URL::asset('images/frontend/Awareness.png') }}" alt="Build Brand Awareness" />
						<h3>Brand Awareness</h3>
						<p></p>
					</a>
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
