<?php
require_once dirname(__FILE__) . '/common.php';

header('Content-Type: application/json');
$ret = array('success' => FALSE);
try {
    $country_id = intval($_POST['country']);
    $latitude = floatval($_POST['latitude']);
    $longitude = floatval($_POST['longitude']);
    $zoom = intval($_POST['zoom']);
    set_country_gis($country_id, $latitude, $longitude, $zoom);
    $ret['success'] = TRUE;
} catch(Exception $e) {
    die('Error while updating row ' . $e->message());
}
echo json_encode($ret);
die();