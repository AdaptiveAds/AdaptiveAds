@extends('default')

@section('content')

<h3>Page Editor</h3>
<h3>Page Title</h3>

<div id="left">
	<div class="pagecontainer"></div>
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
				<a href="/index.php?action=pageeditorHor"><button type="button">Landscape</button></a>
				<a href="/index.php?action=pageeditorVert"><button type="button">Portrait</button></a>
				<div class="clear"></div>
			</li>
			<li>
				<label>Image:</label>
				<input type="text" name="image"><br>
				<input type="submit" value="Submit">
			</li>
			<li><textarea title="content" type="text" name="content" placeholder="Image Meta" required></textarea></li>
			<li>

				<label>Video:</label>
				<input type="text" name="video"><br>
				<input type="submit" value="Submit">
			</li>
			<li><textarea title="content" type="text" name="content" placeholder="Video Meta" required></textarea></li>
			<li><textarea title="content" type="text" name="content" placeholder="Enter Content" required></textarea></li>
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
	</form>
</div>
@endsection
