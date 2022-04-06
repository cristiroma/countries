<?php

require 'util.inc';

/** Validate flag files exist on disk */
function validate_flags() {
  global $em;
  $data = query_countries();
  foreach ($data as $country) {
    $name = $country['name'];
    $code2l = $country['code2l'];
    $png32 = 'data/flags/PNG-32/' . $code2l . '-32.png';
    $png128 = 'data/flags/PNG-128/' . $code2l . '-128.png';
    $svg = 'data/flags/SVG/' . $code2l . '.svg';
    if (!is_readable($png32)) {
      echo "WARN: PNG 32px missing for: {$name}\n";
    }
    if (!is_readable($png128)) {
      echo "WARN: PNG 128px missing for: {$name})\n";
    }
    if (!is_readable($svg)) {
      echo "WARN : SVG missing for: {$name}\n";
    }
  }
  echo "Done\n";
}

validate_flags();