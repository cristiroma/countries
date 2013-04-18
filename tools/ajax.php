<?php
require_once dirname(__FILE__) . '/common.php';
header('Content-Type: application/json');

function ajax_save() {
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
    return $ret;
}

function ajax_get_country() {
    $ret = array('success' => FALSE);
    $country_id = intval($_POST['country']);
    $countries = db_query(sprintf('SELECT * FROM country WHERE id=%d', $country_id));
    if(count($countries) > 0) {
        $ret['country'] = $countries[0];
        $ret['success'] = TRUE;
    }
    return $ret;
}

$fn = 'ajax_' . $_POST['action'];
$ret = array('success' => FALSE);
try {
    $ret = $fn();
} catch(Exception $e) {}

echo json_encode($ret);
die();