<?php
// create a list of installed truetype fonts
// $ fc-list > fonts.txt
// edit file as required
$handle = fopen("fonts.txt", "r");
if ($handle) {
  while (($line = fgets($handle)) !== false) {
    $fonts[] = $line;
  }
  fclose($handle);
}
$text = "Aa Bb Cc Dd Ee Ff Gg Hh Ii Jj Kk Ll Mm Nn Oo Pp Qq Rr Ss Tt Uu Vv Ww Xx Yy Zz";
//$text = 'The Quick Brown Fox Jumps Over The Lazy Dog';
$br = $bg = $bb = 255;
$images = [];
foreach ($fonts as $line) {
  if (trim($line) === '') {
    continue;
  }
  $font_file = substr($line, 0, strpos($line, ':'));
  $name = basename($font_file, '.ttf');
  $img_width = 480;
  $img_height = 480;
  $img = imageCreateTransparent($img_width, $img_height);

  $br = ($br-30 > 0 ? $br-30 : $br-30+255);
  $bg = ($bg-60 > 0 ? $bg-60 : $bg-60+255);
  $bb = ($bb-10 > 0 ? $bb-10 : $bb-10+255);
  $bg_color = imagecolorallocate($img, $br, $bg, $bb);

  $fg_color = imagecolorallocate($img, 255-$br, 255-$bg, 255-$bb);
  imagefilledrectangle($img, 0, 0, $img_width, $img_height, $bg_color);

  $font_size = 20;
  $margin_left = 40;
  $margin_top = 100;
  $font_angle = 0;
  $img_half_height = $img_height / 2;
  $img_half_width = $img_width / 2;

  $text_bbox = imagettfbbox($font_size, $font_angle, $font_file, $text);
  $text_length_chars = strlen($text);
  $text_length_pixels = $text_bbox[4];
  $font_width = $text_length_pixels / $text_length_chars;
  $line_length_max = intval(($img_width - ($margin_left * 2)) / $font_width) ;

  $text_wrapped = wordwrap($text, $line_length_max,PHP_EOL);
  $chunks = explode(PHP_EOL, $text_wrapped);

  $text_window_height = intval($img_height - ($margin_top * 2));
  $line_height = intval($text_window_height / count($chunks));
  $y = $font_size + $margin_top; //$text_window_height - (($line_height * count($chunks))/2);

  foreach ($chunks as $chunk) {
    $chunk_bbox = imagettfbbox($font_size, $font_angle, $font_file, $chunk);
    $chunk_half_width = ($chunk_bbox[4] - $chunk_bbox[6]) / 2;
    $x = $img_half_width - $chunk_half_width;
    imagettftext($img, $font_size, $font_angle, $x, $y, $fg_color, $font_file, $chunk);
    $y += $line_height;
  }
  imagealphablending($img, TRUE);
  imagesavealpha($img, TRUE);
  $file = 'images/' . $name . '.png';
  imagepng($img, $file);
  $images[] = ['file' => $file, 'name' => $name];
  imagecolordeallocate($img, $fg_color);
  imagecolordeallocate($img, $bg_color);
  imagedestroy($img);
//  break;
}

function colorInvert($r, $g, $b){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return $rgb;
}

function imageCreateTransparent($x, $y) {
    $img = imagecreatetruecolor($x, $y);
    $bg_trans = imagecolorallocatealpha($img, 0, 0, 0, 127);
    imagefill($img, 0, 0, $bg_trans);
    return $img;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Fonts</title>
  </head>
  <body>
    <table>
      <?php
      foreach ($images as $img) {
        ?>
        <tr>
          <td><?php echo $img['name']; ?></td>
          <td><img src="<?php echo $img['file']; ?>"></td>
        </tr>
        <?php
      }
      ?>
    </table>
  </body>
</html>
