<?php
include 'include.php';

$resize = isset($_POST['resize']);
$slides = ($resize || isset($_POST['slideshow']));
if ($resize || $slides) {
  $dir_in = $_POST['directory'];
  $size = $_POST['size'];
  $gaq = $_POST['gaq'];
  if (validInput($dir_in, $size)) {
    try {
      if ($result = execute($dir_in, $resize, $size, $slides, $gaq)) {
        if ($slides) {
          $result = '<a href="' . $result . '" target="_blank">' . $result . '</a>';
        } else if ($resize) {
          $result = print_r($result);
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
        <p><button name="resize">Resize Images</button>
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