<?php
require_once dirname(__FILE__) . '/common.php';
function get_countries() {
	return db_query('SELECT * FROM country ORDER BY name');
}

$countries = get_countries();
echo count($countries);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Configure map centers using Google Maps</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta charset="utf-8">
	<link href="/style.css" rel="stylesheet">
</head>
<body>
<h1>Country listing</h1>
<table class="countries">
	<thead>
	<tr>
		<th>#</th>
		<th>Name</th>
		<th>ISO 3166-1<br/>alpha-2</th>
		<th>ISO 3166-1<br/>alpha-3</th>
		<th>Flag (small)</th>
		<th>Flag (large)</th>
		<th>Latitude</th>
		<th>Longitude</th>
		<th>Optimal zoom</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($countries as $idx => $c): ?>
		<tr>
			<td><?php echo $idx + 1; ?>
			<td><?php echo $c->name; ?>
			<td class="center"><?php echo $c->code2l; ?>
			<td class="center"><?php echo $c->code3l; ?>
			<td class="center flag"><img src="data/flags/<?php echo $c->flag_128; ?>"/></td>
			<td class="center flag"><img src="data/flags/<?php echo $c->flag_32; ?>"/></td>
			<td><?php echo $c->latitude; ?>
			<td><?php echo $c->longitude; ?>
			<td><?php echo $c->zoom; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</body>
</html>
