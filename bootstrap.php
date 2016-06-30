<?php


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require __DIR__ . '/vendor/autoload.php';

global $cfg;
$cfg = json_decode(file_get_contents(__DIR__ . '/config.json'));
$isDevMode = TRUE;
$proxyDir = null;
$cache= null;
$isSimpleMode=FALSE;
$dbParams = array(
	'driver' => 'pdo_mysql',
	'user' => $cfg->database->user,
	'password' => $cfg->database->pass,
	'dbname' => $cfg->database->db,
	'charset' =>'utf8'
);
$config= Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Entity"),$isDevMode,$proxyDir,$cache,$isSimpleMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__ . "/src/Entity"), $isDevMode);
$em = EntityManager::create($dbParams, $config);

function slugify($string) {
	$result = strtolower($string);
	$result = preg_replace("/[^a-z0-9\s-]/", "", $result);
	$result = trim(preg_replace("/[\s-]+/", " ", $result));
	$result = preg_replace("/\s/", "-", $result);
	return $result;
}

function get_countries($order = 'c.name') {
	global $em;
	$q = $em->createQuery("SELECT c FROM Country c ORDER BY {$order}");
	return $q->getResult();
}

function get_country_by_code3l($code3l) {
	global $em;
	$q = $em->createQuery('SELECT c FROM Country c WHERE c.code3l = ?1');
	$q->setParameter(1, $code3l);
	return $q->getOneOrNullResult();
}

function set_country_gis($country_id, $latitude, $longitude, $zoom) {
	$conn = db_connect();
	$stmt = $conn->prepare('UPDATE country SET latitude=?, longitude=?, zoom=? WHERE id=?');
	$stmt->bind_param("ddii", $latitude, $longitude, $zoom, $country_id);
	$stmt->execute();
	$stmt->close();
	$conn->close();
}
function get_countries_full($order = 'c.code3l'){
    global $em;
    try {
        $q = $em->createQuery("SELECT c FROM Country c order by {$order}");
        return $q->getResult();
    } catch (\Doctrine\ORM\ORMException $e){
        echo $e->getTraceAsString();
        echo $e->getMessage();
    }
}
