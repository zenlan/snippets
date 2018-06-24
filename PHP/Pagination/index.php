<?php

function getPage($offset, $limit, $total) {
  if ($offset > $total) {
    return ceil($total / $limit);
  }
  return ($offset > 1) ? ceil($offset / $limit) : 1;
}

function getOffset($page, $limit, $start) {
  return ($page > 1) ? (($page - 1) * $limit) + 1 : $start;
}

$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
$offset = (isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0);
$base = (isset($_REQUEST['base']) ? $_REQUEST['base'] : 0);
$limit = (isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 3);
$total = (isset($_REQUEST['total']) ? $_REQUEST['total'] : 16);
$debug = [];
if (isset($_REQUEST['first'])) {
  $page = 1;
}
if (isset($_REQUEST['next'])) {
  $page++;
  $first = 0;
  $last = 0;
}
$offset = getOffset($page, $limit, $base);
$first = (int) $offset;
$debug[] = '<p>offset ' . $offset . ' (base ' . $base . ') was calculated for page: ' . $page . '</p>';
$calc = getPage($offset, $limit, $total);
$debug[] = '<p>page ' . $calc . ' was calculated for offset ' . $offset . ' (base ' . $base . ')' . '</p>';
$first = (int) $offset;
$last = ($first + $limit) - 1;
$table = '';
for ($i = $first; $i <= $last; $i++) {
  if ($i > $total) {
    break;
  }
  $table .= '<td>offset ' . $i . '</td>';
}
if (empty($table)) {
  $table = '<td>---</td>';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Pagination</title>
    <meta http-equiv="Content-type" content="text / html; charset = UTF-8">
    <meta name="viewport" content="width = device-width">
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
        <p>Total:
          <input type="text" name="total" value="<?php echo $total; ?>" size="1"/>
        </p>
        <p>Limit:
          <input type="text" name="limit" value="<?php echo $limit; ?>" size="1"/>
        </p>
        <p>
          <!--          Offset:
                    <input type="text" name="offset" value="<?php echo $offset; ?>" size="1"/>-->
          Page:
          <input type="text" name="page" value="<?php echo $page; ?>" size="1"/>
        </p>
        <p>Offset index
          <br />0:<input type="radio" name="base" value="0" <?php echo $base == 0 ? 'checked' : ''; ?> size="1"/>
          <br />1:<input type="radio" name="base" value="1" <?php echo $base == 1 ? 'checked' : ''; ?> size="1"/>
        </p>
        <div>
          <button name="first">First</button>
          <button name="next">Next</button>
          <table><tr><?php print_r($table); ?></tr></table>
        </div>
      </form>
      <div>
        <?php
        if (!empty($debug)) {
          print_r($debug);
        }
        ?>
      </div>
    </div>
  </body>
</html>