<?php

$sweet = array('a' => 'apple', 'b' => 'banana');
$fruits = array('sweet' => $sweet, 'sour' => 'lemon');

//function test_print($item, $key)
//{
//    echo "$key holds $item<br />";
//}
//
//array_walk_recursive($fruits, 'test_print');

//global $a;
//$a = [];
//
//function test_a($item, $key) {
//  global $a;
//  $a[] =  "$key holds $item<br />";
//}
//array_walk_recursive($fruits, 'test_a');
//print_r($a);

print '<br /><br />';

function test_b($val) {
  if (is_array($val)) {
    return array_map("test_b", $val);    
  }
 return "$val<br />";
}
$b = array_map("test_b", $fruits);
print_r($b);

print '<br /><br />';

//function cube($n) {
//    return($n * $n * $n);
//}
//$a = array(1, 2, 3, 4, 5);
//$b = array_map("cube", $a);
//print_r($b);
//
//print '<br /><br />';