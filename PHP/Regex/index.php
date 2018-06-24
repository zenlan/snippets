<?php

//$links = array(
//  0 => 'LINK:123456|CAPTION:words words words words',
//  1 => 'LINK:345|IMAGE:67',
//  2 => 'LINK:345|IMAGE:67|ALIGN:right',
//  3 => 'LINK:345|IMAGE:67|ALIGN:right|WIDTH:75',
//  4 => 'LINK:345|IMAGE:67|ALIGN:right|WIDTH:75|CAPTION:this image is called',
//  5 => 'Link:345|Image:67|Align:right|Width:75|Caption:this image is called',
//);
//
//$format = '/(?P<link>LINK:.*)(\|CAPTION:(?P<caption>.*))/is';
//$format = '/(?P<link>LINK:.*)(\|IMAGE:(?P<image>.*)?)(\|ALIGN:(?P<align>.*)?)(\|WIDTH:(?P<width>.*)?)(\|CAPTION:(?P<caption>.*)?)/is';
//foreach ($links as $string) {
//  echo 'matching string ' . $string;
//  echo '<br />';
//  $split = preg_split('/\|/', $string, -1, PREG_SPLIT_NO_EMPTY);
//  $result = '';
//  foreach ($split as $token) {
//    $tmp = explode(':', $token);
//    $result[strtoupper($tmp[0])] = $tmp[1];
//  }
//  print_r($result);
//  if ($i = preg_match($format, $string, $matches)) {
//    echo 'match found: at pos ' . $pos . ' : ' . print_r($matches, 1);
//  }
//  else {
//    echo 'no match found';
//  }
//}
//$regex = '/\*(|[^_].*?)\*/';
//$string = '*bold text*';
//$regex = '/award\/[\d]{4}\/[-\w]+\/?$/i';
//$string = 'award/2012/tv-craft/documentary';
//$string = 'award/2012/tv-craft/';
//$regex = '/keyword-search/i';
//$string = 'keyword-search?asdfalsj=aljsdljasf';
//return (preg_match('/award\/[\d]{4}\/[-\w]+\/?$/i', $path, $matches) ? TRUE : FALSE);
//return (preg_match('/award\/[\d]{4}\/[-\w]+\/?$/i', $_GET['q']) ? TRUE : FALSE);
//$a = preg_match('/keyword-search/i', $_GET['q']);
//$b = preg_match('/award\/[\d]{4}\/[-\w]+\/?$/i', $_GET['q']);
//echo ($a > 0 ? 'KEYWORD SEARCH' : $b > 0 ? 'AWARDS PAGE' : 'NEITHER');
//echo (preg_match('/keyword-search/i', $_GET['q']) > 0 ? 'KEYWORD SEARCH' : preg_match('/award\/[\d]{4}\/[-\w]+\/?$/i', $_GET['q']) > 0 ? 'AWARDS PAGE' : 'NEITHER');
//if ($i = preg_match($regex, $string, $matches)) {
//  echo 'match found: at pos ' . $pos . ' : ' . print_r($matches, 1);
//}
//else {
//  echo 'no match found';
//}
//echo '<br />';

/* SPACES AND SINGLE CHARS */

//$count = 0;
//$string = ' TITLE A B  C   D ';
//echo $string;
//echo '<br />';
//$pattern = '/([\s]{2,})/iu';
//$i = preg_match($pattern, $string, $matches);
//$result = preg_replace($pattern, ' ', $string, -1, $count);
//$pattern = '/\\b([a-z])\\b ?/i';
//$i = preg_match($pattern, $string, $matches);
//$result = preg_replace($pattern, ' ', $string, -1, $count);

/* ASCII CHARS */
//$string = '';
//for($i=33;$i<127;$i++) {
//  $string .= chr($i) . ' ';
//}
//echo $string;
//echo '<br />';
//echo '<br />';
//$pattern = '/[\x21-\x2F\x3A-\x40\x5B-\x60\x7B-\x7E]/i';
//$i = preg_match($pattern, $string, $matches);
//$result = preg_replace($pattern, '', $string, -1, $count);
//
//echo $result;
//echo '<br />';

/* CONSECUTIVE SPACE-DELIMITED DUPLICATES */
//$string = 'this, is, is, is, a, is, a, list';
//echo $string;
//echo '<br />';
//echo '<br />';
//$delim = ',';
//$pattern = '/(?<=' . $delim . '|^)([^' . $delim . ']*)(' . $delim . '\1)+(?=' . $delim . '|$)/i';
//$i = preg_match($pattern, $string, $matches);
//$result = preg_replace($pattern, '', $string, -1, $count);
//
//echo $result;
//echo '<br />';

/* DUPLICATE WORDS */
//$string = 'this is is is a is a string';
//echo $string;
//echo '<br />';
//echo '<br />';
//$pattern = '/\b([A-Z]+)\s+\1\b/i';
//$i = preg_match($pattern, $string, $matches);
//$result = preg_replace($pattern, '', $string, -1, $count);
//
//echo $result;
//echo '<br />';
//$stopwords = array(
//    'a',
//    'the',
//    'an',
//    'am',
//    'is',
//    'can',
//    'and',
//    'or',
//    'but',
//    'while',
//    'if',
//    'then',
//    'there',
//    'were',
//    'when',
//    'thus',
//    'of',
//    'that',
//    'on',
//    'to',
//    'from',
//    'in',
//    'for',
//    'any',
//    'he',
//    'we',
//    'which',
//    'his',
//    'he',
//    'she',
//    'they',
//    'them',
//  );
//$string = 'THE ARRIVAL OF THE FIRST FLOTILLA OF DESTROYERS FROM AMERICA TO THE ROYAL NAVY, DEVONPORT, SEPTEMBER 1940 OF';
//foreach ($stopwords as $k => $word) {
//  $stopwords[$k] = '/^|\s' . $word . '\s|$/i';
//}
//$result = preg_replace($stopwords, ' ', $string);
//echo $result;
//echo '<br />';
//$test[] = 'bs_status:"false"';
//$test[] = 'bs_status:"true"';
//$test[] = 'bs_status:"bar"';
//$test[] = 'bs_status:"foo"';
//$test[] = 'bs_foo:"true"';
//$test[] = 'bs_bar:"false"';
//$test[] = 'bs_foo:"bar"';
//print 'INPUT:<br />';
//print_r($test);
//print '<br />';
//print '<br />';
//
//$pattern = '/([_\w]+):("(false|true)")/';
//$pos = preg_grep($pattern, $test);
//print 'POS:<br />';
//print_r($pos);
//print '<br />';
//print '<br />';
//
//foreach ($pos as $k => $subject) {
//  $test[$k] = preg_replace($pattern, '$1:$3', $subject);
//}
//print 'RESULTS:<br />';
//print_r($test);
//print '<br />';
//print '<br />';
// STOPWORDS
//$test[] = 'space on the left of and on the right';
//$test[] = 'and starting a sentence';
//$test[] = ',and after a comma';
//$test[] = '.and after a period';
//$test[] = 'ending a sentence with and';
//$test[] = 'after a comma is,and';
//$test[] = 'after a period is.and';
//$pattern = '/\b(' . 'and' . ')\b/iuS';
//print 'INPUT:<br />';
//print_r($test);
//print '<br />';
//print '<br />';
//foreach ($test as $k => $subject) {
//  $test[$k] = preg_replace($pattern, ' ', $subject, -1, $count);
//}
//print 'RESULTS:<br />';
//print_r($test);
//print '<br />';
//print '<br />';
// SPACES
//$test[] = '3   spaces';
//$test[] = '2  spaces';
//$test[] = '1 spaces';
//$pattern = '/(\s+)/iuS';
//foreach ($test as $k => $subject) {
//  print $k .' before: ' . strlen($subject);
//  print '<br />';
//  $subject = preg_replace($pattern, ' ', $subject, -1, $count);
//  print $k .' after: ' . strlen($subject);
//  print '<br />';
//  print '<br />';
//}
// NON-WORDS WITH EXCEPTIONS
//$test[] = 'all NON !"£$%^&*(){}{}@~\'#<>?,.+_-=|\¬`/ words except quotes, spaces and dashes';
//$pattern = '/[^\-\'\sa-z]+/iuS';
//foreach ($test as $k => $subject) {
//  print $k .' before: ' . $subject;
//  print '<br />';
//  $subject = preg_replace($pattern, ' ', $subject, -1, $count);
//  print $k .' after: ' . $subject;
//  print '<br />';
//  print '<br />';
//}
// DUPLICATES
//  return preg_replace('/\b([A-Z]+)\s+\1\b/ui', '', $string, -1, $count);
// SOLO CHARS
//$test[] = 'some solo C E G K L , CHARS';
//$pattern = '/\s([a-z])\s/uiS';
//foreach ($test as $k => $subject) {
//  print $k .' before: ' . $subject;
//  print '<br />';
//  $subject = preg_replace($pattern, ' ', $subject, -1, $count);
//  print $k .' after: ' . $subject;
//  print '<br />';
//  print '<br />';
//}


$array = [['foo1' => 'bar1', 'foo2' => 'bar2',], ['foo3' => 'bar3', 'foo4' => 'bar4']];
$inputs = json_encode($array);
//print_r($inputs);
//print('<br />');
//$subject = '--inputs=\'' . $inputs . '\' --foo="bar"';
$subject = '--inputs=' . $inputs . ' --foo="bar"';
print('SUBJECT => ' . $subject);
print('<br /><br />');
//$pattern = '/--([_a-z]+)=/';
//$i = preg_match_all($pattern, $subject, $matches);
//print('<br />');
//print_r($matches);
//print('<br />');
$args = explode('--', $subject);
print('EXPLODED => ');
print_r($args);
print('<br /><br />');

function isJson($string) {

  $pattern = '/[{:}]+/';
  $i = preg_match_all($pattern, $subject, $matches);


  json_decode($string);
  return (json_last_error() == JSON_ERROR_NONE);
}

foreach ($args as $k => $v) {
  if (!empty($v)) {
    $pattern = '/[a-z]+=(\[.*\])/';
    if ($i = preg_match($pattern, $v, $matches)) {
      $value = json_decode($matches[1]);
      if (json_last_error() == JSON_ERROR_NONE) {
        print("ARG $k IS JSON ARRAY => ");
      }
      else {
        print("ARG $k IS ARRAY => ");
      }
    }
    else {
      print("ARG $k IS SCALAR => ");
      $value = trim(trim(substr($v, strpos($v, '=') + 1), '"'), '\'');
    }
    print_r($value);
    print('<br /><br />');
  }
}

