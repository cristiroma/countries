<?php
require_once 'bootstrap.php';
$countries = get_countries();
include_once 'includes/header.inc';
?>
<div class="container">
  <h1>List of countries</h1>
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
    <?php foreach ($countries as $idx => $c): ?>
      <tr>
        <td><a name="<?php print $c->getCode3l(); ?>" href="detail.php?code=<?php echo $c->getCode3l(); ?>"><?php echo $c->getName(); ?></a>
        <td class="center"><?php echo $c->getCode3l(); ?>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php include_once 'includes/footer.inc'; ?>
