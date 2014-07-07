<?php
global $config;
$config = json_decode(file_get_contents(dirname(__FILE__) . '/../config.json'));

function db_connect() {
	global $config;
	$conn = new mysqli(
		$config->database->host,
		$config->database->user,
		$config->database->pass,
		$config->database->db,
		$config->database->port
	);
	if ($conn->connect_error) {
		die(sprintf("Connect failed: %s\n", $conn->connect_error));
	} else {
		// var_dump($conn->host_info);
	}
	return $conn;
}

function db_query($sql) {
	$conn = db_connect();
	$ret = array();
	if ($cur = $conn->query($sql)) {
		while ($row = $cur->fetch_object()) {
			$ret[] = $row;
		}
		$cur->free();
	} else {
		var_dump($conn);
		die('Query failed');
	}
	$conn->close();
	return $ret;
}


function set_country_gis($country_id, $latitude, $longitude, $zoom) {
	$conn = db_connect();
	$stmt = $conn->prepare('UPDATE country SET latitude=?, longitude=?, zoom=? WHERE id=?');
	$stmt->bind_param("ddii", $latitude, $longitude, $zoom, $country_id);
	$stmt->execute();
	$stmt->close();
	$conn->close();
}
