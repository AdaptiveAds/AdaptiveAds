@extends('default')

@section('content')

<h3>Playlist Timings</h3>
<h3>Page Title</h3>

<div id="left">
	<div class="pagecontainer">
		<form action="action_page.php">
			<div id="startend">
				<ul>
					<li>
						<label>Start Date:</label>
						<input type="date" name="startdate"><input type="submit">
					</li>
					<li>
						<label>End Date</label>
						<input type="date" name="enddate"><input type="submit">
					</li>

				</ul>
			</div>
			<div id="daily">
				<ul>
					<li>
						<label>Monday</label>
						<input type="checkbox" name="vehicle1" value="monday">
					</li>
					<li>
						<label>06:00</label>
						<input type="checkbox" name="vehicle1" value="6">
					</li>
					<li>
						<label>11:00</label>
						<input type="checkbox" name="vehicle1" value="11">
					</li>
					<li>
						<label>14:00</label>
						<input type="checkbox" name="vehicle1" value="14">
					</li>
					<li>
						<label>17:00</label>
						<input type="checkbox" name="vehicle1" value="17">
					</li>
					<li>
						<label>22:00</label>
						<input type="checkbox" name="vehicle1" value="22">
					</li>
				</ul>
			</div>
			<div class="clear"></div>
		</form>
	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->
	<form name="advertlist" action="index_submit" method="get" accept-charset="utf-8">
		<ul>
			<li><button type="button">Up</button></li>
			<li><button type="button">Down</button></li>
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
	</form>
</div>
@endsection
