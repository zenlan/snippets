<?php

function UCFirstSentence($input) {
  $input = strtolower(trim($input));
  $len = strlen($input);
  $lchunk = '';
  $initchar = substr($input, 0, 1);
  $rchunk = substr($input, 1);
  $input = $lchunk . strtoupper($initchar) . $rchunk;
  $i = strpos($input, '. ');
  while ($i > 0 && $i < $len) {
    $n = 2;
    $lchunk = substr($input, 0, $i + 2);
    $rchunk = ltrim(substr($input, $i + 2));
    $initchar = substr($rchunk, 0, 1);
    $rchunk = substr($rchunk, 1);
    $input = $lchunk . strtoupper($initchar) . $rchunk;
    $i = strpos($input, '. ', $i + 2);
  }
  return $input;
}

$strings[] = 'The quick brown FOX.';
$strings[] = 'THE QUICK BROWN. FOX JUMPS. OVER THE LAZY. DOG.';
$strings[] = 'The quick brown fox. Jumps over the lazy dog. HOW NOW BROWN COW';
$strings[] = 'FIRST. SECOND.THIRD. FOURTH.';
$strings[] = 'Sentences with.  double.  spacing.';
$strings[] = 'Mrs Smith went to Washington in WWII.';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sentence Case Conversion</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <style>
      table {padding:5px;border:1px solid grey;}
      th {padding:5px;border:1px solid grey;background-color:#666;color:#fff};
      .odd {background-color:#ccc;}
      .even {background-color:#eee;}
    </style>
  </head>
  <body>
    <h1>Sentence Case Conversion</h1>
    <table>
      <tr><th>Before</th><th>After</th></tr>
      <?php
      foreach ($strings as $i => $string) {
        $class = fmod($i, 2) ? 'even' : 'odd';
        ?>        
        <tr><td class="<?php echo $class; ?>"><? echo $string; ?></td><td class="<?php echo $class; ?>"><? echo UCFirstSentence($string); ?></td></tr>        
        <?php
      }
      ?>
    </div>
</body>
</html>