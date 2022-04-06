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


json();
csv();
css();