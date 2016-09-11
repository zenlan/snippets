<?php



function zenlan_ac1($arg) {
  $string = base64_decode($arg);
  $results = zenlan_service_ac1($string);
  drupal_json_output($results);
}

function zenlan_service_ac1($string) {
  $values = array(
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
  foreach ($values as $id => $name) {
    if (strpos($name, $string) !== FALSE) {
      $results[] = array('value' => $id, 'label' => $name);
    }
  }
  return $results;
}

function zenlan_ac2($string) {
  $results = zenlan_service_ac2($string);
  drupal_json_output($results);
}

function zenlan_service_ac2($string) {
  $values = array(
      'one' => 'one',
      'two' => 'two',
      'three' => 'three',
      'four' => 'four',
      'five' => 'five',
      'six' => 'six',
      'seven' => 'seven',
      'eight' => 'eight',
      'nine' => 'nine',
  );
  $results = array();
  foreach ($values as $id => $name) {
    if (strpos($name, $string) !== FALSE) {
      $results[$id] = $name;
    }
  }
  return $results;
}

function zenlan_ac3($string) {

  $results = zenlan_service_ac2($string);
  drupal_json_output($results);
}

function zenlan_service_ac3($string) {
  $results = zenlan_service_ac3($string);
  return array_values($results);
}