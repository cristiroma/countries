<?php
	require_once dirname(__FILE__) . '/common.php';
	function get_invalid_countries() {
			return db_query('SELECT * FROM country WHERE latitude IS NULL or LONGITUDE IS NULL');
	}
	$invalid_c = get_invalid_countries();
?>
<!DOCTYPE html>
<html>
  <head>
	<title>Configure map centers using Google Maps</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta charset="utf-8">
	<link href="http://countries.localhost/style.css" rel="stylesheet">
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://countries.localhost/script.js"></script>
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
				<option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
			<?php endforeach; ?>
		</select>
		<button id="save">Save</button>
	</div>
	<div id="map-canvas"></div>
  </body>
</html>
