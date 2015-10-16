<?php
require_once __DIR__ . '/../bootstrap.php';
if (empty($_GET['code']) || strlen($_GET['code']) != 3) {
  die('Invalid country code');
}
/** @var Country $country */
$country = get_country_by_code3l($_GET['code']);
$regions = get_country_regions($country->getId());
$page_title = $country->getNameOfficial();
include_once 'includes/header.inc';
?>
<div class="container">
  <div class="page-header">
    <div class="pull-right"><a href="/#<?php print $country->getCode3l(); ?>">Back to list</a></div>
    <h1 class="">
      <img src="data/flags/<?php print $country->getFlag128(); ?>" style="margin-right: 10px;" />
      <?php print $country->getNameOfficial(); ?></h1>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Country name</h3>
    </div>
    <div class="panel-body">
      <dl class="dl-horizontal pull-left">
        <dt>Name</dt>
        <dd><?php print $country->getName(); ?></dd>

        <dt>Official name</dt>
        <dd><?php print $country->getNameOfficial(); ?></dd>

      <?php if (!empty($regions)): ?>
        <dt>Regions</dt>
        <dd>
      <?php foreach($regions as $region): ?>
        <?php print $region->getName(); ?>,
      <?php endforeach; ?>
        </dd>
      <?php endif; ?>
      </dl>
      <div class="pull-right">

        <img src="data/flags/<?php print $country->getFlag32(); ?>" style="border: 1px solid #c0c0c0; margin-right: 10px;" />
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Geographical information</h3>
    </div>
    <div class="panel-body">
      <dl class="dl-horizontal pull-left">
      <?php if (!empty($regions)): ?>
        <dt>Regions</dt>
        <dd>
          <?php foreach($regions as $region): ?>
            <?php print $region->getName(); ?>,
          <?php endforeach; ?>
        </dd>
      <?php endif; ?>
        <dt>Latitude</dt>
        <dd><?php print $country->getLatitude(); ?></dd>
        <dt>Longitude</dt>
        <dd><?php print $country->getLongitude(); ?></dd>
        <dt>Optimal zoom</dt>
        <dd><?php print $country->getZoom(); ?></dd>
      </dl>
      <div id="map" class="pull-right" style="width: 400px; height: 400px;"></div>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApZu296XxM7Z8h4SMpVgWO_z-spvRaMXI&callback=initMap" async defer></script>
      <script>
        var map;
        function initMap() {
          map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: <?php print $country->getLatitude(); ?>, lng: <?php print $country->getLongitude(); ?> },
            zoom: <?php print $country->getZoom(); ?>
          });
        }
      </script>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.inc'; ?>