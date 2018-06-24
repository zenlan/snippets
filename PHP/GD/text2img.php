<?php

function imageCreateTransparent($x, $y) {
    $imageOut = imagecreatetruecolor($x, $y);
    $backgroundColor = imagecolorallocatealpha($imageOut, 0, 0, 0, 127);
    imagefill($imageOut, 0, 0, $backgroundColor);
    return $imageOut;
}

$image = imageCreateTransparent(600, 600);

$white = imagecolorallocate($image, 255, 255, 255);
$grey = imagecolorallocate($image, 128, 128, 128);
$black = imagecolorallocate($image, 0, 0, 0);

$colpairs = [
  0 => ['bg' => $white, 'fg' => $black],
  1 => ['bg' => $black, 'fg' => $white],
  2 => ['bg' => $grey, 'fg' => $black],
  3 => ['bg' => $black, 'fg' => $grey],
  4 => ['bg' => $grey, 'fg' => $white],
  5 => ['bg' => $white, 'fg' => $grey],
];

$font = '/usr/share/fonts/truetype/ubuntu-font-family/Ubuntu-MI.ttf';
$text = 'The Quick Brown Fox Jumps over the Lazy Dog';
$font_size = 20;
$rect_height = 100;
$rect_top = 0;

foreach ($colpairs as $i => $pair) {
  imagefilledrectangle($image, 0, $rect_top, 600, $rect_top+$rect_height, $pair['bg']);
  imagettftext($image, $font_size, 0, 10, $rect_top+($rect_height/2), $pair['fg'], $font, $text);
  $rect_top += $rect_height;
}

//imagealphablending($image, true); //not needed as we created the image with alpha
//imagesavealpha($image, true);
imagepng($image, 'text2img.png');
//header( "Content-type: image/png" );
//imagepng($image);
imagedestroy($image);

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Fonts</title>
  </head>
  <body>
    <img src="text2img.png" style="border: 1px solid #000;">
  </body>
</html>
