<?php

function execute($dir_in, $resize, $size, $slides, $gaq) {
  $result = FALSE;
  $dir_name = basename($dir_in);
  if (!$dir_out = getDirOut($dir_name)) {
    throw 'Failed to create output directory';
  } else {
    if ($resize) {
      echo "getFiles($dir_in)<br>";
      $files = getFiles($dir_in);
      $result = doResize($files, $dir_out, $size);
    }
    if ($slides) {
      if (!$result = doSlidesHTML($dir_name, $dir_out, $gaq)) {
        throw 'Failed to create html file for ' . $dir_name;
      }
    }
  }
  return $result;
}

function validInput($dir_in, $size) {
  if (!is_dir($dir_in)) {
    throw 'invalid directory';
  } else if (!is_numeric($size)) {
    throw 'invalid size';
  }
  return TRUE;
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
    asort($files, SORT_NUMERIC);
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

function doResize($files, $dir_out, $size, $hash = FALSE, $format = NULL) {
  $result = [];
  foreach ($files as $fileinfo) {
    $path = $fileinfo['dirname'] . '\\' . $fileinfo['basename'];
    if (!file_exists($path)) {
      exit();
    }
    if ($img = imageIn($path, $fileinfo['extension'])) {
      if (!$hash) {
        $name = $fileinfo['basename'];
      } else {
        $name = hash('md5', $fileinfo['basename']);
      }
      if (file_exists($dir_out . $name)) {
        @unlink($dir_out . $name);
      }
      list($width, $height) = getimagesize($path);
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
        if (imageOut($img_scaled, $dir_out . $name, ($format ? $format : $fileinfo['extension']))) {
//        if (imagepng($img_scaled, $dir_out . $name)) {
//          if (imagejpeg($img_scaled, $dir_out . $name)) {
          $result[$path] = $dir_out . $name;
        }
      }
      imagedestroy($img);
    }
  }
  return $result;
}

function imageIn($path, $format) {
  $gd = FALSE;
  switch ($format) {
    case 'bmp': $gd = imagecreatefrombmp($path);
      break;
    case 'gif': $gd = imagecreatefromgif($path);
      break;
    case 'jpg':
    case 'jpeg': $gd = imagecreatefromjpeg($path);
      break;
    case 'png': $gd = imagecreatefrompng($path);
      break;
  }
  return $gd;
}

function imageOut($gd, $path, $format) {
  $ok = FALSE;
  switch ($format) {
    case 'bmp': $ok = imagewbmp($gd, $path);
      break;
    case 'gif': $ok = imagegif($gd, $path);
      break;
    case 'jpg':
    case 'jpeg': $ok = imagejpeg($gd, $path);
      break;
    case 'png': $ok = imagepng($gd, $path);
      break;
  }
  return $ok;
}

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

function getSubDirs($dir_in) {
  $result = [];
  if ($files = scandir($dir_in)) {
    foreach ($files as $file) {
      $path = $dir_in . '\\' . $file;
      if (substr($file, 0, 1) !== '.') {
        if (is_dir($path)) {
          $result[] = pathinfo($path);
        }
      }
    }
  }
  return $result;
}

function getFiles($dir_in, $format = NULL) {
  $result = [];
  try {
    if ($files = scandir($dir_in)) {
      foreach ($files as $file) {
        $path = $dir_in . '\\' . $file;
        if (substr($file, 0, 1) !== '.') {
          if (is_file($path)) {
            $info = pathinfo($path);
            if ($format && $info['extension'] == $format) {
              $result[] = $info;
            } else if (!$format) {
              $result[] = $info;
            }
          }
        }
      }
    }
  } catch (Exception $exc) {
    echo $exc->getMessage();
  }
  return $result;
}
