<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201407071327
 */

require_once 'www/common.php';

global $argv;

if(count($argv) < 2) {
	echo "Usage: php build.php <json|csv>\n";
	exit(-1);
}

$cmd = $argv[1];

call_user_func("exec_$cmd");

function exec_json() {
	global $config;
	$countries = db_query('SELECT * FROM country ORDER BY name');
	$v = json_encode($countries, JSON_PRETTY_PRINT);
	file_put_contents($config->json_dump, $v);
}

function exec_csv() {
	global $config;
	$countries = db_query('SELECT * FROM country ORDER BY name');

	$fp = fopen($config->csv_dump, 'w');
	fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
	foreach($countries as $country) {
		$row = array();
		$row[0] = $country->name;
		$row[1] = $country->code2l;
		$row[2] = $country->code3l;
		$row[3] = $country->flag_32;
		$row[4] = $country->flag_128;
		$row[5] = $country->latitude;
		$row[6] = $country->longitude;
		$row[7] = $country->zoom;
		fputcsv($fp, $row);
	}
	fclose($fp);
}