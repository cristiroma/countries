<?php

function query_countries($order_by = 'name'): array {
  $ret = [];
  $conn = new mysqli('localhost', 'root', 'root', 'countries');
  $rows = $conn->query('SELECT * FROM country ORDER BY ' . $order_by);
  foreach($rows as $row) {
    $r = [];
    $r['id'] = $row['id'];
    $r['enabled'] = $row['id'] == '1' ?? FALSE;
    $r['code3l'] = $row['code3l'];
    $r['code2l'] = $row['code2l'];
    $r['name'] = $row['name'];
    $r['name_official'] = $row['name_official'];

    $r['center'] = [];
    if (!empty($row['latitude']) && !empty($row['longitude']) && !empty($row['zoom'])) {
      $r['center']['latitude'] = $row['latitude'];
      $r['center']['longitude'] = $row['longitude'];
      $r['center']['zoom'] = $row['zoom'];
    }
    $ret[] = $r;
  }
  $rows->close();
  $conn->close();
  return $ret;
}

function query_names($country_id): array {
  static $data;
  if (empty($data)) {
    $conn = new mysqli('localhost', 'root', 'root', 'countries');
    $rows = $conn->query('SELECT * FROM country_name ORDER BY code2l, language');
    foreach($rows as $row) {
      $id = $row['country_id'];
      $language = $row['language'];
      if (strtolower($language) != 'en') {
        $name = $row['name'];
        $name_official = $row['name_official'];
        $data[$id][$language]['name'] = $name;
        $data[$id][$language]['name_official'] = $name_official;
      }
    }
    $rows->close();
    $conn->close();
  }
  return $data[$country_id] ?? [];
}

function query_full_countries($order_by = 'name'): array {
  $data = [];
  $countries = query_countries($order_by);
  foreach ($countries as $c) {
    $id = $c['id'];
    $names = query_names($id);
    $c['names'] = $names;
    $data[] = $c;
  }
  return $data;
}
