@include('pages/header')

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
					<a  title="Return Home" name="lnkDashboard" href="{{ URL::to('/')}}"><i class="fa fa-home" aria-hidden="true"></i></a>
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
							<li><a name="lnkDashboard" href="{{ URL::to('/')}}">Home</a></li>
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
