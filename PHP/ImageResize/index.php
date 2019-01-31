<?php

function doScale() {
  $result = [];
  $files = ['source_landscape.jpg', 'source_portrait.jpg'];
  foreach ($files as $file) {
    if ($img = @imagecreatefromjpeg($file)) {
      $name = str_replace('source', 'target', $file);
      list($width, $height) = getimagesize($file);
      $scale = 0.5;
      $new_width = round($width * $scale, 0, PHP_ROUND_HALF_UP);
      if ($new_width) {
        $img_scaled = imagescale($img, $new_width);
        if (imagejpeg($img_scaled, $name)) {
          $result[$file] = $name;
        }
      }
      imagedestroy($img);
    }
  }
  return $result;
}

if (isset($_POST['resize'])) {
  $images = doScale();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Image Resize</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <style>
      body {font-family:sans-serif;}
      div {padding:10px;}
      img {padding:5px;border:1px solid blue;text-align:center;}
    </style>
  </head>
  <body>
    <div style="float:left;">
      <form action="" method="POST">
        <p><button name="resize">Resize Images</button></p>
      </form>
    </div>
    <div style="float:none;clear:both;">
      <?php
      if (isset($images)) {
        ?>
        <table>
          <caption>Images resized</caption>
          <?php
          foreach ($images as $source => $scaled) {
            ?>
            <tr>
              <td><img src="<?php echo $source; ?>"></td>
              <td><img src="<?php echo $scaled; ?>"></td>
            </tr>
            <?php
          }
          ?>
        </table>
        <?php
      } else if (isset($result)) {
        print_r($result);
      } else if (isset($error)) {
        print_r($error);
      }
      ?>
    </div>
  </body>
</html>