<?php

class TotCsv {

  function prepareCSV($aCols, $filename, &$err) {
    if (empty($aCols)) {
      $err = 'missing header';
      return false;
    }
    $tmp = APPPATH . '/tmp/';
    if (!(file_exists($tmp) && is_writeable($tmp))) {
      $tmp = sys_get_temp_dir();
    }
    $fname = $tmp . $filename;
    if (file_exists($fname)) {
      @unlink($fname);
      if (file_exists($fname)) {
        $err = 'failed to remove old file ' . $fname;
        return false;
      }
    }
    if (!($fh = @fopen($fname, "w"))) {
      $err = 'failed to open file ' . $fname;
      return false;
    }
    if (!($bytes = fputcsv($fh, $aCols))) {
      $err = 'failed to write to file ' . $fname;
      fclose($fh);
      return false;
    }
    fclose($fh);
    return $fname;
  }

  function writeCSVRow($aRow, $fname, &$err) {
    if (empty($aRow)) {
      $err = 'missing row';
      return false;
    }
    if (!file_exists($fname)) {
      $err = 'file does not exist ' . $fname;
      return false;
    }
    if (!($fh = @fopen($fname, "a"))) {
      $err = 'failed to open file ' . $fname;
      return false;
    }
    if (!($bytes = fputcsv($fh, $aRow, ',', '"'))) {
      $err = 'failed to write to file ' . $fname;
      fclose($fh);
      return false;
    }
    fclose($fh);
    return $fname;
  }

  function writeCSV($aRows, $filename, &$err) {
    $retval = false;
    if (!empty($aRows)) {
      $tmp = APPPATH . '/tmp/';
      if (!(file_exists($tmp) && is_writeable($tmp))) {
        $tmp = sys_get_temp_dir();
      }
      $fname = $tmp . $filename;
      if ($fh = @fopen($fname, "w")) {
        $aCols = array_keys($aRows[0]);
        $retval = $fname;
        $numRows = 0;
        if ($bytes = fputcsv($fh, $aCols)) {
          foreach ($aRows AS $k => $aVals) {
            if (!($bytes = fputcsv($fh, $aVals))) {
              $retval = false;
              break;
            }
          }
        }
        fclose($fh);
      }
      else {
        $err = 'failed to open file ';
      }
      // unlink($tfname);
    }
    else if (empty($aCols)) {
      $err = 'missing header';
    }
    else if (empty($aRows)) {
      $err = 'no values to export';
    }
    return $retval;
  }

  function readCSV($name, &$err, $aMandatoryFields = array()) {
    $retval = false;
    $file = $_FILES[$name]['tmp_name'];
    if ($fh = @fopen($file, 'r')) {
      $aRows[0] = fgetcsv($fh);
      if (empty($aRows[0])) {
        $err = 'file empty';
        return $retval;
      }
      foreach ($aMandatoryFields as $fld) {
        if (!in_array($fld, $aRows[0])) {
          $err = 'missing field from header: ' . $fld;
          return $retval;
        }
      }
      while ($aRows[] = fgetcsv($fh)) {

      }
      $retval = $aRows;
    }
    else {
      $err = 'failed to open file ';
    }
    return $retval;
  }

  function toSQLValues($aRows, $delim = '') {
    $aResult = array();
    foreach ($aRows AS $k => $aValues) {
      if ($aValues) {
        $aResult[] = '(' . $delim . implode($delim . ',' . $delim, $aValues) . $delim . ')';
      }
    }
    return $aResult;
  }

  function toSQLInsertArray($aRows, $table) {
    $aResult = array();
    $cols = implode(',', $aRows[0]);
    unset($aRows[0]);
    foreach ($aRows AS $k => $aValues) {
      if ($aValues) {
        $aResult[] = 'INSERT INTO ' . $table . ' ( ' . $cols .
            ' ) VALUES (' . implode('","', $aValues) . ' ) ';
      }
    }
    return $aResult;
  }

}
?>
<p><a  href="/test">back to test index</a></p>