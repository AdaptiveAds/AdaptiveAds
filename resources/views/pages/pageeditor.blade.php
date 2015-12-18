@extends('default')

@section('content')

<h3>Page Editor</h3>
<h3>Page Title</h3>

<div id="left" class="landscape">
	<div class="pagecontainer">
		<ul>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
	<div class="pagecontainer">
		<ul>
			<li><a href="#">Theme</a></li>
			<li><a href="#">Theme</a></li>
			<li><a href="#">Theme</a></li>
			<li><a href="#">Theme</a></li>
			<li><a href="#">Theme</a></li>
		</ul>
	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->
	<form name="pageEditor" action="index_submit" method="get" accept-charset="utf-8">
		<ul>
			<li id="orientation">
				<button class="btn-orientationHor" type="button">Landscape</button>
				<button class="btn-orientationVert" type="button">Portrait</button>
				<div class="clear"></div>
			</li>
			<li>
				<label>Image:</label>
				<input type="text" name="image"><br>
				<input class="submit" type="submit" value="Submit">
			</li>
			<li><textarea title="content" type="text" name="content" placeholder="Image Meta" required></textarea></li>
			<li>

				<label>Video:</label>
				<input type="text" name="video"><br>
				<input class="submit" type="submit" value="Submit">
			</li>
			<li><textarea title="content" type="text" name="content" placeholder="Video Meta" required></textarea></li>
			<li><textarea title="content" type="text" name="content" placeholder="Enter Content" required></textarea></li>
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
	</form>
</div>
@endsection
