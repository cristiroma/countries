<?php
	header('Content-type: text/html; charset=UTF-8');
	require_once dirname(__FILE__) . '/common.php';
	$invalid_c = db_query('SELECT * FROM country WHERE (latitude IS NULL) or (LONGITUDE IS NULL) or (zoom IS NULL) ORDER BY name');
	$valid_c = db_query('SELECT * FROM country WHERE (latitude IS NOT NULL) or (LONGITUDE IS NOT NULL) or (zoom IS NOT NULL) ORDER BY name');
?>
<!DOCTYPE html>
<html>
  <head>
	<title>Configure map centers using Google Maps</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="/style.css" rel="stylesheet" />
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="/script.js"></script>
  </head>
  <body>
	<h1>Set country headers</h1>
	<p>
		<em>Instructions</em>: Select country from list, drag and zooom the map to have it best centered on the selected country. Press Save when you're satisfied
	</p>
	<div id="controls">
		<label for="country">Country</label>
		<select id="country">
				<option value="">-- Please select --</option>
			<?php foreach($invalid_c as $c): ?>
				<option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
			<?php endforeach; ?>
		</select>
		<button id="save">Save</button>
		<div id="coordinates"></div>
	</div>
	<div id="existing">
		<label for="valid">Valid countries (select to see on map)</label>
		<select id="valid">
			<option value="">-- Please select--</option>
			<?php foreach($valid_c as $c): ?>
			<option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
			<?php endforeach; ?>
		</select>
		<button id="existing_update">Update</button>
	</div>
	<div id="map-canvas"></div>
  </body>
</html>
