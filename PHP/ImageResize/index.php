<?php

function getDirOut($name) {
  $dir_out = 'resized';
  if (!file_exists($dir_out)) {
    mkdir($dir_out);
  }
  $dir_out .= '/' . $name;
  if (!file_exists($dir_out)) {
    mkdir($dir_out);
  }
  if (file_exists($dir_out)) {
    return $dir_out . '/';
  } else {
    return FALSE;
  }
}

function doResize($files, $dir_in, $dir_out, $size) {
  $result = [];
  foreach ($files as $file) {
    if ($file[0] !== '.') {
      if ($img = @imagecreatefromjpeg($dir_in . '/' . $file)) {
        $name = hash('md5', $file);
        list($width, $height) = getimagesize($dir_in . '/' . $file);
        $aspect = ($width > $height ? 'landscape' : 'portrait');
        $ratio = $width / $height;
        $new_width = ($aspect == 'landscape' ? $size : round($size * ($width / $height), 0, PHP_ROUND_HALF_UP));
        $new_height = ($aspect == 'portrait' ? $size : round($size * ($height / $width), 0, PHP_ROUND_HALF_UP));
        if ($new_width && $new_height) {
          $img_scaled = imagescale($img, $new_width, $new_height);
          if (imagejpeg($img_scaled, $dir_out . $name)) {
            $result[$file] = $dir_out . $name;
          }
        }
        imagedestroy($img);
      }
    }
  }
  return $result;
}

function doSlidesHTML($dir_name, $dir_out) {
  $outfile = $dir_out . 'index.html';
  @unlink($outfile);
  if (file_exists($outfile)) {
    return FALSE;
  }
  if (!$files = scandir($dir_out)) {
    return FALSE;
  } else {
    $tpl_html = file_get_contents('lightbox.html');
    $tpl_indic = '               <li data-target="#lightbox" data-slide-to="{n}" class="{active}"></li>';
    $tpl_items = '               <div class="carousel-item {active}">
                  <img class="d-block w-100" src="{name}" title="{n}" alt="{n}"/>
                  <div class="carousel-caption d-none d-md-block"><p>{n}</p></div>
                </div>';
    $indicators = '';
    $items = '';
    $n = 0;
    foreach ($files as $file) {
      if ($file[0] !== '.') {
        $active = ($n > 0 ? '' : 'active');
        $indicators .= str_replace('{n}', $n, str_replace('{active}', $active, $tpl_indic)) . "\n";
        $n++;
        $items .= str_replace('{n}', $n, str_replace('{name}', $file, str_replace('{active}', $active, $tpl_items))) . "\n";
      }
    }
    $html = str_replace('{title}', $dir_name, $tpl_html);
    $html = str_replace('{indicators}', $indicators, $html);
    $html = str_replace('{items}', $items, $html);
    file_put_contents($outfile, $html);
    if (!file_exists($outfile)) {
      return FALSE;
    }
    return $outfile;
  }
}

if (isset($_POST['resize']) || isset($_POST['slideshow'])) {
  $size = 440;
  if (!is_dir($_POST['directory'])) {
    $error = 'invalid directory';
  } else {
    $dir_in = $_POST['directory'];
    $dir_name = basename($dir_in);
    $dir_out = getDirOut($dir_name);
  }
  if (!$dir_out) {
    $error = 'Failed to create output directory';
  } else if (!$files = scandir($dir_in)) {
    $error = 'No files found';
  } else {
    if (isset($_POST['resize'])) {
      $images = doResize($files, $dir_in, $dir_out, $size);
    } else if (isset($_POST['slideshow'])) {
      if (!$result = doSlidesHTML($dir_name, $dir_out)) {
        $error = 'Failed to create html file';
      } else {
        $result = '<a href="' . $result . '" target="_blank">' . $result . '</a>';
      }
    }
  }
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
      table, td {padding:5px;border:1px solid grey;text-align:center;}
      th {padding:5px;border:1px solid grey;background-color:#666;color:#fff};
    </style>
  </head>
  <body>
    <div style="float:left;">
      <form action="" method="POST">
        <p>
          Directory
          &nbsp;<input type="text" name="directory" value="<?php echo (isset($_POST['directory']) ? $_POST['directory'] : ''); ?>" size="64"/>
          &nbsp;<button name="resize">Resize Images</button>
          &nbsp;<button name="slideshow">Generate slideshow</button>
        </p>
      </form>
    </div>
    <div style="float:none;clear:both;">
      <?php
      if (isset($images)) {
        ?>
        <table>
          <caption>Images resized</caption>
          <?php
          foreach ($images as $name => $src) {
            ?>
            <tr>
              <td><?php echo $name; ?></td>
              <td><img src="<?php echo $src; ?>"></td>
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