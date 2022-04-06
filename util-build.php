<?php

require 'util.inc';

function json() {
  $data = query_full_countries();
  $v = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  file_put_contents('data/countries.json', $v);
}

function csv() {
  $data = query_full_countries();
  $fp = fopen('data/countries.csv', 'w');
  fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
  foreach ($data as $c) {
    $row = array();
    $row[0] = $c['name'];
    $row[1] = $c['name_official'];
    $row[2] = $c['code2l'];
    $row[3] = $c['code3l'];
    $row[4] = $c['center']['latitude'];
    $row[5] = $c['center']['longitude'];
    $row[6] = $c['center']['zoom'];
    fputcsv($fp, $row);
  }
  fclose($fp);
}

/** Generate the CSS sprite */
function css() {
  $countries = query_countries('code2l');
  $content = <<<EOT
.flag { width: 128px; height: 64px; background: url(countries-large.png) no-repeat 0; }
.flag.small { width: 32px; height: 16px; background: url(countries-small.png) no-repeat 0; }
\n
EOT;
  $xl = $yl = $xs = $ys = $i = 0;
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
.flag.large-{$country['code2l']}, .flag.large-{$country['code3l']} { background-position: {$xlp} {$ylp}; }
.flag.small-{$country['code2l']}, .flag.small-{$country['code3l']} { background-position: {$xsp} {$ysp}; }
\n
EOT;
    $xl -= 128;
    $xs -= 32;
    $i++;
  }
  file_put_contents('data/css/countries.css', $content);
}

function sqlite() {
  $db = new SQLite3('data/countries.db');
  $db->exec('DROP TABLE IF EXISTS country');
  $db->exec('CREATE TABLE country(id INTEGER PRIMARY KEY, enabled INT, code3l TEXT, code2l TEXT, name TEXT, name_official TEXT, latitude REAL, longitude REAL, zoom INT)');

  $db->exec('DROP TABLE IF EXISTS country_name');
  $db->exec('CREATE TABLE country_name(id INTEGER PRIMARY KEY, country_id INT, code2l TEXT, language TEXT, name TEXT, name_official TEXT, source TEXT)');

  $db->exec('DROP TABLE IF EXISTS country_region');
  $db->exec('CREATE TABLE country_region(id INTEGER PRIMARY KEY, country_id INT, region_id INT)');

  $db->exec('DROP TABLE IF EXISTS region');
  $db->exec('CREATE TABLE region(id INTEGER PRIMARY KEY, name TEXT, is_unep INT)');

  // country
  $rows = query_countries();
  foreach ($rows as $row) {
    $enabled = $row['enabled'] ? 1 : 0;
    $st = $db->prepare("INSERT INTO country (id, enabled, code3l, code2l, name, name_official, latitude, longitude, zoom) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $st->bindValue(1, $row['id'], SQLITE3_INTEGER);
    $st->bindValue(2, $enabled, SQLITE3_INTEGER);
    $st->bindValue(3, $row['code3l']);
    $st->bindValue(4, $row['code2l']);
    $st->bindValue(5, $row['name']);
    $st->bindValue(6, $row['name_official']);
    $st->bindValue(7, $row['center']['latitude'], SQLITE3_FLOAT);
    $st->bindValue(8, $row['center']['longitude'], SQLITE3_FLOAT);
    $st->bindValue(9, $row['center']['zoom'], SQLITE3_INTEGER);
    $st->execute();
    $st->close();
  }

  // country_name
  foreach ($rows as $row) {
    $id = $row['id'];
    $names = query_names($id);
    foreach($names as $language => $name) {
      $st = $db->prepare("INSERT INTO country_name (country_id, code2l, `language`, `name`, name_official, `source`) VALUES(?, ?, ?, ?, ?, ?)");
      $st->bindValue(1, $id, SQLITE3_INTEGER);
      $st->bindValue(2, $row['code2l']);
      $st->bindValue(3, $language);
      $st->bindValue(4, $name['name']);
      $st->bindValue(5, $name['name_official']);
      $st->bindValue(6, $name['source']);
      $st->execute();
      $st->close();
    }
  }

  // regions
  $rows = query_regions();
  foreach ($rows as $row) {
    $st = $db->prepare("INSERT INTO region (id, `name`, is_unep) VALUES(?, ?, ?)");
    $st->bindValue(1, $row['id'], SQLITE3_INTEGER);
    $st->bindValue(2, $row['name']);
    $st->bindValue(3, $row['is_unep'], SQLITE3_INTEGER);
    $st->execute();
    $st->close();
  }

  // country_region
  $rows = query_country_regions();
  foreach ($rows as $row) {
    $st = $db->prepare("INSERT INTO country_region (id, country_id, region_id) VALUES(?, ?, ?)");
    $st->bindValue(1, $row['id'], SQLITE3_INTEGER);
    $st->bindValue(2, $row['country_id'], SQLITE3_INTEGER);
    $st->bindValue(3, $row['region_id'], SQLITE3_INTEGER);
    $st->execute();
    $st->close();
    if (empty($row['country_id'])) var_dump($row);
  }

  $db->close();
}

//
//json();
//csv();
//css();
sqlite();