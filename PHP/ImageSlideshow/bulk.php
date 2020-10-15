<?php
include 'include.php';

$resize = isset($_POST['resize']);
$slides = ($resize || isset($_POST['html']));
if ($resize || $slides) {
  $dir_in = $_POST['directory'];
  $size = $_POST['size'];
  $gaq = $_POST['gaq'];
  if (validInput($dir_in, $size)) {
    try {
      $subdirs = getSubDirs($dir_in);
      $result = '';
      if (!empty($subdirs)) {
        foreach ($subdirs as $pathinfo) {
          $dir_name = $pathinfo['basename'];
          $din = $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['basename'];
          if ($result = execute($din, $resize, $size, TRUE, $gaq)) {
            if ($slides) {
              $result = '<a href="' . $result . '" target="_blank">' . $result . '</a>';
            } else if ($resize) {
              $result = print_r($result);
            }
          }
        }
        $outdirs = getSubDirs('resized');
        if (!$link = doListingHTML($outdirs, 'resized', $gaq)) {
          throw 'Failed to create html listing file';
        } else {
          $result = '<a href="' . $link . '" target="_blank">' . $link . '</a>';
        }
      }
    } catch (Exception $exc) {
      echo $exc->getMessage();
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
      th {padding:5px;border:1px solid grey;background-color:#666;color:#fff;}
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