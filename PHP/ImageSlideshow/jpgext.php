<?php

function getFiles($dir, $action, $format = 'JPG') {
  $result = [];
  if ($files = scandir($dir)) {
    foreach ($files as $file) {
      $path = $dir . '\\' . $file;
      if (substr($file, 0, 1) !== '.') {
        if (is_file($path)) {
          $info = pathinfo($path);
          if ($action == 'add' && !isset($info['extension'])) {
            $result[] = $info;
          } else if ($action == 'rem' && isset($info['extension']) && strtoupper($info['extension']) == $format) {
            $result[] = $info;
          }
        }
      }
    }
  }
  return $result;
}

if (isset($_POST['extadd']) || isset($_POST['extrem'])) {
  if (!is_dir($_POST['directory'])) {
    $error = 'invalid directory';
  } else {
    $dir = $_POST['directory'];
    $dir_name = basename($dir);
    $action = isset($_POST['extadd']) ? 'add' : 'rem';
    $files = getFiles($dir, $action);
    foreach ($files as $fileinfo) {
      $old = $fileinfo['dirname'] . '\\' . $fileinfo['basename'];
      if ($action == 'add') {
        $new = $fileinfo['dirname'] . '\\' . $fileinfo['basename'] . '.JPG';
      } else if ($action == 'rem') {
        $new = $fileinfo['dirname'] . '\\' . $fileinfo['filename'];
      }
      $ok = rename($old, $new);
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
        <p>
          <button name="extadd">Add JPG extension</button>
          &nbsp;
          <p><button name="extrem">Remove JPG extension</button>
        </p>
      </form>
    </div>
  </body>
</html>