<?php
require_once __DIR__ . '/../bootstrap.php';
$countries = get_countries();
include_once 'includes/header.inc';
?>
<div class="container">
  <h1>List of countries</h1>
  <p>
    <a href="data/json/countries.json">Download JSON</a> | <a href="data/csv/countries.csv">Download CSV</a>
  </p>
  <p>
    Click on any country to see the its details
  </p>
  <table class="table ">
    <thead>
    <tr>
      <th>Name</th>
      <th>ISO code</th>
    </tr>
    </thead>
    <tbody>
    <?php
    /** @var Country $c */
    foreach ($countries as $idx => $c):
      $filename = slugify($c->getCode3l()) . '.html';
      ?>
      <tr>
        <td>
          <a name="<?php print $c->getCode3l(); ?>" href="<?php print $filename; ?>"><?php echo $c->getName(); ?></a>
        </td>
        <td class="center">
          <?php echo $c->getCode3l(); ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php include_once 'includes/footer.inc'; ?>
