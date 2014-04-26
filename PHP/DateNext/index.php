<?php
define('DATE_FORMAT', 'D j F Y H:i');

function getHours() {
  $result = array(
      0 => array(
          'day' => 'Sun',
          'start' => '1000',
          'end' => '1700',
      ),
      1 => array(
          'day' => 'Mon',
          'start' => '1100',
          'end' => '1200',
      ),
      2 => array(
          'day' => 'Tue',
          'start' => '1200',
          'end' => '1300',
      ),
      3 => array(
          'day' => 'Wed',
          'start' => '1300',
          'end' => '1400',
      ),
      4 => array(
          'day' => 'Thu',
          'start' => '1400',
          'end' => '1500',
      ),
      5 => array(
          'day' => 'Fri',
          'start' => '1500',
          'end' => '1600',
      ),
      6 => array(
          'day' => 'Sat',
          'start' => '1600',
          'end' => '1700',
      ),
  );
  return $result;
}

function getNext($start, $end, $date = NULL) {

  $object = new stdClass();
  $object->finished = FALSE;
  $object->started = FALSE;

  $object->hours = getHours();
  $object->t_start = strtotime(trim($start));
  $object->t_end = strtotime(trim($end));

  if (is_null($date) || (strtotime($date)) === false) {
    $object->t_date = strtotime('now');
  } else {
    $object->t_date = strtotime($date);
  }
  $object->today = date(DATE_FORMAT, $object->t_date);

  $object->dow = date('w', $object->t_date);
  $object->hod = date('H', $object->t_date) * 100;

  $object->tomorrow = mktime($object->hours[($object->dow < 6 ? $object->dow + 1 : 0)]['start'] / 100, 0, 0, date('n', $object->t_date), date('j', $object->t_date), date('Y', $object->t_date)) + (24 * 60 * 60);

  $object->t_start += (($object->hours[date('w', $object->t_start)]['start'] / 100) * (60 * 60));
  $object->start = date(DATE_FORMAT, $object->t_start);

  $object->t_end += (($object->hours[date('w', $object->t_end)]['end'] / 100) * (60 * 60));
  $object->end = date(DATE_FORMAT, $object->t_end);

  if ($object->t_date < $object->t_start) {
    $object->next = 'not started';
  } elseif ($object->t_date < $object->t_end) {
    $object->started = TRUE;
    if ($object->hod < $object->hours[$object->dow]['end']) {
      $object->next = date(DATE_FORMAT, $object->t_date);
    } else if ($object->tomorrow < $object->t_end) {
      $object->next = date(DATE_FORMAT, $object->tomorrow);
    }
  } else {
    $object->finished = TRUE;
    $object->next = 'finished';
  }
  return $object;
}

$defaults['start'] = date('j F Y', strtotime('-1 week'));
$defaults['end'] = date('j F Y', strtotime('+1 week'));
$defaults['now'] = date('j F Y H:i', strtotime('now'));
$hours = getHours();

if (isset($_POST['go'])) {
  $now = (isset($_POST['now']) && !empty($_POST['now']) ? trim($_POST['now']) : NULL);
  $result = getNext($_POST['start_date'], $_POST['end_date'], $now);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Next Date</title>
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
      <table>
        <caption>Event Timetable</caption>
        <tr><th>Day</th><th>Starts</th><th>Ends</th></tr>
        <?php
        foreach ($hours as $k => $v) {
          ?>
          <tr><td><?php echo $v['day']; ?></td><td><?php echo substr($v['start'],0,2) . ':' . substr($v['start'],2,2); ?></td><td><?php echo substr($v['end'],0,2) . ':' . substr($v['end'],2,2); ?></td></tr>
          <?php
        }
        ?>
      </table>
    </div>
    <div style="float:left;">
      <form action="" method="POST">
        <p>Event Starts: <input class="datepicker" type="text" name="start_date" value="<?php echo (isset($_POST['start_date']) ? $_POST['start_date'] : $defaults['start']); ?>" maxlength="18" size="18"/></p>
        <p>Event Ends: <input class="datepicker" type="text" name="end_date" value="<?php echo (isset($_POST['end_date']) ? $_POST['end_date'] : $defaults['end']); ?>" maxlength="18" size="18"/></p>
        <p>Today is:<input class="datepicker" type="text" name="now" value="<?php echo (isset($_POST['now']) ? $_POST['now'] : $defaults['now']); ?>" size="24"/></p>
        <p><button name="go">When is the next event?</button></p>
      </form>
    </div>
    <div style="float:none;clear:both;">
      <table>
        <tr><th>Starts</th><th>Ends</th><th>Today</th><th>Next</th></tr>
        <tr>
          <td><?php echo $result ? $result->start : '???'; ?></td>
          <td><?php echo $result ? $result->end : '???'; ?></td>
          <td><?php echo $result ? $result->today : '???'; ?></td>
          <td><?php echo $result ? $result->next : '???'; ?></td>
        </tr>
      </table>
      <div style="float:none;clear:both;">
        <?php
        if (isset($result)) {
          print_r($result);
        }
        ?>
      </div>
    </div>
  </body>
</html>