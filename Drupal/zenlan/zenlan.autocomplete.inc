<?php

function zenlan_ac1($arg) {
  $array = array(
      1 => 'one',
      2 => 'two',
      3 => 'three',
      4 => 'four',
      5 => 'five',
      6 => 'six',
      7 => 'seven',
      8 => 'eight',
      9 => 'nine',
  );
  $results = array();
  $string = base64_decode($arg);
  foreach ($array as $id => $name) {
    if (strpos($name, $string) !== FALSE) {
      $results[] = array('value' => $id, 'label' => $name);
    }
  }
  drupal_json_output($results);
}

function zenlan_ac2($arg) {
  $array = array(
      'one',
      'two',
      'three',
      'four',
      'five',
      'six',
      'seven',
      'eight',
      'nine',
  );
  $array = array_combine(array_values($array), array_values($array));
  $string = $arg;
  foreach ($array as $id => $name) {
    if (strpos($name, $string) !== FALSE) {
      $results[$id] = $name;
    }
  }
  drupal_json_output($results);
}
