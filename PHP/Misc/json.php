<?php

$value = json_encode([["name" => "mytest1", "type" => "text_format", "label" => "MyTest1", "options" => "", "description" => "Input 1", "maxlength" => "1", "size" => "1", "default_value" => "foo1", "weight" => "0", "fieldset" => ""], ["name" => "mytest2", "type" => "text_format", "label" => "MyTest2", "options" => "", "description" => "Input 2", "maxlength" => "2", "size" => "2", "default_value" => "foo2", "weight" => "1", "fieldset" => ""]]);
print_r($value);

if (preg_match_all('/[{:}]+/', $value, $matches)) {
  $value = json_decode($value);
  $err = json_last_error();
  if ($err !== JSON_ERROR_NONE) {
    $value = NULL;
  }
  else {
    $value = json_decode(json_encode($value), TRUE);
  }
}
print('<br /><br />');
print_r($value);