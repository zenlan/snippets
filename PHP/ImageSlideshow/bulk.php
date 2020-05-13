<?php

function getDirOut($name) {
  $dir_out = 'resizedbulk';
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

function getSubDirs($dir_in) {
  $result = [];
  if ($files = scandir($dir_in)) {
    foreach ($files as $file) {
      $path = $dir_in . '\\' . $file;
      $tmp = is_dir($path);
      if (substr($file, 0, 1) !== '.') {
        if (is_dir($path)) {
          $result[] = pathinfo($path);
        }
      }
    }
  }
  return $result;
}

function getFiles($dir_in, $format = 'JPG') {
  $result = [];
  if ($files = scandir($dir_in)) {
    foreach ($files as $file) {
      $path = $dir_in . '\\' . $file;
      $tmp = is_dir($path);
      if (substr($file, 0, 1) !== '.') {
        if (is_file($path)) {
          $info = pathinfo($path);
          if ($info['extension'] == $format) {
            $result[] = $info;
          }
        }
      }
    }
  }
  return $result;
}

function doResize($files, $dir_out, $size) {
  $result = [];
  foreach ($files as $fileinfo) {
    $file = $fileinfo['dirname'] . '\\' . $fileinfo['basename'];
    if (!file_exists($file)) {
      exit();
    }
    if ($img = @imagecreatefromjpeg($file)) {
      $name = hash('md5', $fileinfo['basename']);
      if (file_exists($dir_out . $name)) {
        @unlink($dir_out . $name);
      }
      list($width, $height) = getimagesize($file);
      $aspect = ($width > $height ? 'landscape' : 'portrait');
      $ratio = $width / $height;
      $new_width = ($aspect == 'landscape' ? $size : round($size * ($width / $height), 0, PHP_ROUND_HALF_UP));
      $new_height = ($aspect == 'portrait' ? $size : round($size * ($height / $width), 0, PHP_ROUND_HALF_UP));
      if ($new_width && $new_height) {
        $img_scaled = imagescale($img, $new_width, $new_height);
//        $scale = 0.1;
//        $new_width = round($width * $scale, 0, PHP_ROUND_HALF_UP);
//        if ($new_width) {
//          $img_scaled = imagescale($img, $new_width);
        if (imagejpeg($img_scaled, $dir_out . $name)) {
          $result[$file] = $dir_out . $name;
        }
      }
      imagedestroy($img);
    }
  }
  return $result;
}

function doSlidesHTML($dir_name, $dir_out, $gaq) {
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
    $html = str_replace('{gaq}', $gaq, $html);
    $html = str_replace('{indicators}', $indicators, $html);
    $html = str_replace('{items}', $items, $html);
    file_put_contents($outfile, $html);
    if (!file_exists($outfile)) {
      return FALSE;
    }
    return $outfile;
  }
}

function doListingHTML($subdirs, $dir_out, $gaq) {
  $outfile = $dir_out . '/index.html';
  @unlink($outfile);
  if (file_exists($outfile)) {
    return FALSE;
  }
  if (empty($subdirs)) {
    return FALSE;
  } else {
    $tpl_items = '<h2 class="display-6"><a href="{href}">{title}</a></h2>';
    $items = '';
    $n = 0;
    foreach ($subdirs as $pathinfo) {
      $dir_name = $pathinfo['basename'];
      $dir_out = getDirOut($dir_name);
      $dir_in = $pathinfo['dirname'] . '\\' . $dir_name;
      $n++;
      $items .= str_replace('{href}', $dir_name, str_replace('{title}', $dir_name, $tpl_items)) . "\n";
    }
    $html = str_replace('{gaq}', $gaq, file_get_contents('listing.html'));
    $html = str_replace('{items}', $items, $html);
    file_put_contents($outfile, $html);
    if (!file_exists($outfile)) {
      return FALSE;
    }
    return $outfile;
  }
}

if (isset($_POST['resize']) || isset($_POST['html'])) {
  $dir_in = $_POST['directory'];
  $size = $_POST['size'];
  $gaq = $_POST['gaq'];
  if (!is_dir($dir_in)) {
    $error = 'invalid directory';
  } else if (!is_numeric($size)) {
    $error = 'invalid size';
  } else {
    $subdirs = getSubDirs($dir_in);
    $result = [];
    if (!empty($subdirs)) {
      foreach ($subdirs as $pathinfo) {
        $dir_name = $pathinfo['basename'];
        $dir_out = getDirOut($dir_name);
        $dir_in = $pathinfo['dirname'] . '\\' . $dir_name;
        if (!$dir_out) {
          $error = 'Failed to create output directory';
        } else {
          if (isset($_POST['resize'])) {
            $files = getFiles($dir_in);
            $images = doResize($files, $dir_out, $size);
          }
          if (!$link = doSlidesHTML($dir_name, $dir_out, $gaq)) {
            $error = 'Failed to create html file for ' . $dir_name;
          }
        }
      }
      $outdirs = getSubDirs('resizedbulk');
      if (!$link = doListingHTML($outdirs, 'resizedbulk', $gaq)) {
        $error = 'Failed to create html listing file';
      } else {
        $result[] = '<a href="' . $link . '" target="_blank">' . $link . '</a>';
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Slideshow</title>
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
        <p><label for="directory">Source directory</label>
          &nbsp;<input type="text" id="directory" name="directory" value="<?php echo (isset($_POST['directory']) ? $_POST['directory'] : ''); ?>" size="64"/>
        </p>
        <p><label for="size">Target size of longest side in pixels</label>
          &nbsp;<input type="text" id="size" name="size" value="<?php echo (isset($_POST['size']) ? $_POST['size'] : 440); ?>" size="6"/>
        </p>
        <p><label for="gaq">Google Analytics</label>
          &nbsp;<input type="text" id="gaq" name="gaq" value="<?php echo (isset($_POST['gaq']) ? $_POST['gaq'] : ''); ?>" size="10"/>
        </p>
        <p>
          <button name="resize">Resize and generate HTML</button>
          &nbsp;
          <button name="html">Generate HTML only</button>
        </p>
      </form>
    </div>
    <div style="float:none;clear:both;">
      <?php
      if (isset($result)) {
        ?>
        <table>
          <caption>Created</caption>
          <?php
          foreach ($result as $link) {
            ?>
            <tr>
              <td><?php echo $link; ?></td>
            </tr>
            <?php
          }
          ?>
        </table>
        <?php
      } else if (isset($error)) {
        print_r($error);
      }
      ?>
    </div>
  </body>
</html>