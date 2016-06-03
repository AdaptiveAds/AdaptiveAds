@extends('backend')

@section('content')

<section>
	<article>
		<header>
			<h2>Chris Zielazny</h2>
			<h4>Business IT</h4>
		</header>
		<img src="{{ URL::asset('images/frontend/chris.jpg') }}">
		<p><a href="https://uk.linkedin.com/in/preecejoshua"><i class="fa fa-linkedin" aria-hidden="true"></i></a></p>
	</article>
	<article>
		<header>
			<h2>Phantom</h2>
			<h4>Web Developer (Ghost)</h4>
		</header>
		<img src="{{ URL::asset('images/frontend/Phantom.png') }}">
		<p><a href="http://lmgtfy.com/?q=How+do+I+find+out+information+about+an+AWOL+university+student%3F"><i title="AWOL Member - No details available" class="fa fa-linkedin fail" aria-hidden="true"></i></a></p>
	</article>
	<article>
		<header>
			<h2>Josh Preece</h2>
			<h4>Lead Database Developer</h4>
		</header>
		<img src="{{ URL::asset('images/frontend/josh.jpg') }}">
		<p><a href="https://uk.linkedin.com/in/preecejoshua"><i class="fa fa-linkedin" aria-hidden="true"></i>></a></p>
	</article>
	<article>
		<header>
			<h2>Liam Harries</h2>
			<h4>Lead Tester</h4>
		</header>
		<img src="{{ URL::asset('images/frontend/liam.jpg') }}">
		<p><a href="https://uk.linkedin.com/in/liamharries"><i class="fa fa-linkedin" aria-hidden="true"></i>></a></p>
	</article>
	<article>
		<header>
			<h2>Kane Whelan</h2>
			<h4>Lead Web Developer</h4>
		</header>
		<img src="{{ URL::asset('images/frontend/kane.jpg') }}">
		<p><a href="https://uk.linkedin.com/in/kane-whelan-5700b758"><i class="fa fa-linkedin" aria-hidden="true"></i></a></p>
	</article>
</section>
@endsection
