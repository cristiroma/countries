<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201407071327
 */

require_once 'bootstrap.php';

global $argv;

if(count($argv) < 2) {
	echo "Usage: php build.php <json|csv|validate_flags|gh_pages>\n";
	exit(-1);
}

$cmd = $argv[1];

call_user_func("exec_$cmd");

/** Export SQL data in JSON */
function exec_json() {
  global $config;
  $countries = db_query('SELECT * FROM country ORDER BY name');
  $v = json_encode($countries, JSON_PRETTY_PRINT);
  file_put_contents($config->json_dump, $v);
}

/** Export SQL data in CSV */
function exec_csv() {
  global $config;
  $countries = db_query('SELECT * FROM country ORDER BY name');

  $fp = fopen($config->csv_dump, 'w');
  fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
  foreach ($countries as $country) {
    $row = array();
    $row[0] = $country->name;
    $row[1] = $country->name_official;
    $row[2] = $country->code2l;
    $row[3] = $country->code3l;
    $row[4] = $country->flag_32;
    $row[5] = $country->flag_128;
    $row[6] = $country->latitude;
    $row[7] = $country->longitude;
    $row[8] = $country->zoom;
    fputcsv($fp, $row);
  }
  fclose($fp);
}

/** Validate flag files exist on disk */
function exec_validate_flags() {
  $countries = db_query('SELECT * FROM country ORDER BY name');
  foreach ($countries as $country) {
    if (empty($country->flag_32)) {
      echo "WARN:  32-pixel flag not set for: {$country->name}\n";
    }
    else {
      $f32 = "data/flags/{$country->flag_32}";
      if (!is_file($f32)) {
        echo "ERR :  missing  32-pixel flag on disk for: {$country->name}\n";
      }
    }
    if (empty($country->flag_128)) {
      echo "WARN: 128-pixel flag not set for: {$country->name}\n";
    }
    else {
      $f128 = "data/flags/{$country->flag_128}";
      if (!is_file($f128)) {
        echo "ERR :  missing 128-pixel flag on disk for: {$country->name}\n";
      }
    }
  }
  echo "No output above means everything is OK\n";
}

function exec_gh_pages() {
  ob_start();
  require_once 'www/gh-index.php';

  mkdir('gh-pages');
  $data = ob_get_clean();
  if ($f = fopen('gh-pages/index.html', 'w+')) {
    fwrite($f, $data);
    fclose($f);
  }
  $countries = get_countries();
  /** @var Country $country */
  foreach ($countries as $country) {
    $filename = slugify($country->getCode3l()) . '.html';
    if ($f = fopen('gh-pages/' . $filename, 'w+')) {
      $_GET['code'] = $country->getCode3l();
      ob_start();
      $page_title = $country->getNameOfficial();
      require 'www/includes/header.inc';
      require 'www/detail.php';
      require 'www/includes/footer.inc';
      $data = ob_get_clean();
      fwrite($f, $data);
      fclose($f);
    }
  }
}

/** Generate the CSS sprite */
function exec_css() {
  global $cfg;

  $countries = get_countries('c.code2l');
  $content = <<<EOT
.flag { width: 128px; height: 64px; background: url(countries-large.png) no-repeat 0; }
.flag.small { width: 32px; height: 16px; background: url(countries-small.png) no-repeat 0; }
\n
EOT;
  $xl = $yl = $xs = $ys = $i = 0;
  /** @var Country $country */
  foreach ($countries as $country) {
    if ($i % 10 == 0 && $i) {
      $yl -= 64;
      $ys -= 16;
      $xl = 0;
      $xs = 0;
    }
    $xlp = $xl == 0 ? $xl : $xl . 'px';
    $xsp = $xs == 0 ? $xs : $xs . 'px';
    $ylp = $yl == 0 ? $yl : $yl . 'px';
    $ysp = $ys == 0 ? $ys : $ys . 'px';

    $content .= <<<EOT
.flag.large-{$country->getCode2l()}, .flag.large-{$country->getCode3l()} { background-position: {$xlp} {$ylp}; }
.flag.small-{$country->getCode2l()}, .flag.small-{$country->getCode3l()} { background-position: {$xsp} {$ysp}; }
\n
EOT;
    $xl -= 128;
    $xs -= 32;
    $i++;
  }
  file_put_contents($cfg->css_sprite, $content);
}
