<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201407071327
 */

require_once 'bootstrap.php';

global $argv;

if (count($argv) < 2) {
  echo "Usage: php build.php <css|json|csv|validate_flags|gh_pages>\n";
  exit(-1);
}

$cmd = $argv[1];

call_user_func("exec_$cmd");

/** Export SQL data in JSON */
function exec_json() {
  global $cfg, $em;
  $q = $em->createQuery("SELECT c FROM Country c ORDER BY c.name");
  $data = $q->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
  $v = json_encode($data, JSON_PRETTY_PRINT);
  file_put_contents($cfg->json_dump, $v);
}

/** Export SQL data in CSV */
function exec_csv() {
  global $cfg, $em;
  $q = $em->createQuery("SELECT c FROM Country c ORDER BY c.name");
  $data = $q->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

  $fp = fopen($cfg->csv_dump, 'w');
  fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
  foreach ($data as $country) {
    $row = array();
    $row[0] = $country['name'];
    $row[1] = $country['name_official'];
    $row[2] = $country['code2l'];
    $row[3] = $country['code3l'];
    $row[4] = $country['flag_32'];
    $row[5] = $country['flag_128'];
    $row[6] = $country['latitude'];
    $row[7] = $country['longitude'];
    $row[8] = $country['zoom'];
    fputcsv($fp, $row);
  }
  fclose($fp);
}

/** Validate flag files exist on disk */
function exec_validate_flags() {
  global $em;
  $q = $em->createQuery("SELECT c FROM Country c ORDER BY c.name");
  $data = $q->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
  foreach ($data as $country) {
    $name = $country['name'];
    $flag_32 = $country['flag_32'];
    $flag_128 = $country['flag_128'];
    if (empty($flag_32)) {
      echo "WARN: PNG 32px flag not set for: {$name}\n";
    }
    else {
      $f32 = "../data/flags/PNG-32/{$flag_32}";
      if (!is_file($f32)) {
        echo "ERR : Missing PNG 32px flag on disk for: {$name}\n";
      }
    }
    if (empty($flag_128)) {
      echo "WARN: PNG 128px flag not set for: {$name} ({$f32})\n";
    }
    else {
      $f128 = "../data/flags/PNG-128/{$flag_128}";
      if (!is_file($f128)) {
        echo "ERR : Missing 128px flag on disk for: {$name} ({$f128})\n";
      }
    }
    $svg = '../data/flags/svg/' . $country['code2l'] . '.svg';
    if (!is_file($svg)) {
      echo "ERR : Missing SVG flag on disk for: {$name} ({$f128})\n";
    }
  }
  echo "No output above means everything is OK\n";
}

function exec_gh_pages() {
  global $em;
  $q = $em->createQuery("SELECT c FROM Country c ORDER BY c.name");
  $data = $q->getResult();

  $loader = new \Twig\Loader\FilesystemLoader('./templates');
  $twig = new \Twig\Environment($loader, []);
  $index_tpl = $twig->load('index.html');
  $languages = [
    'ar' => 'Arabic',
    'en' => 'English',
    'es' => 'Spanish',
    'fr' => 'French',
    'it' => 'Italian',
    'zh' => 'Chinese',
    'ru' => 'Russian',
  ];

  $countries = [];
  /**
   * @var int $i
   * @var \Country $country
   */
  foreach ($data as $i => $country) {
    $row = new stdClass();
    $row->name = $country->getName();
    $row->official_name = $country->getNameOfficial();
    $row->code2l = $country->getCode2l();
    $row->code3l = $country->getCode3l();
    $row->zoom = $country->getZoom();
    $row->latitude = $country->getLatitude();
    $row->longitude = $country->getLongitude();
    $row->svg = sprintf('https://raw.githubusercontent.com/cristiroma/countries/master/data/flags/SVG/%s.svg?sanitize=true', strtoupper($row->code2l));
    $row->png32 = sprintf('https://raw.githubusercontent.com/cristiroma/countries/master/data/flags/PNG-32/%s-32.png', strtoupper($row->code2l));
    $row->png128 = sprintf('https://raw.githubusercontent.com/cristiroma/countries/master/data/flags/PNG-128/%s-128.png', strtoupper($row->code2l));

    $country_names = $country->getCountryNames();
    $names = [];
    /** @var \CountryName $name */
    foreach($country_names as $name) {
      $names[$languages[$name->getLanguage()]] = $name->getName();
    }
    $row->names = $names;

    $country_regions = $country->getCountryRegions();
    $regions = [];
    /** @var \CountryRegion $name */
    foreach($country_regions as $region) {
      $regions[] = $region->getRegion()->getName();
    }
    $row->regions = $regions;
    $countries[$i] = $row;

    $out = sprintf('gh-pages/%s.html', $row->code2l);
    var_dump($out);
    file_put_contents($out, $twig->load('country.html')->render(['country' => $row]));
  }
  $content = $index_tpl->render(['countries' => $countries]);
  if (!is_dir('gh-pages')) {
    mkdir('gh-pages');
  }
  file_put_contents('gh-pages/index.html', $content);
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
