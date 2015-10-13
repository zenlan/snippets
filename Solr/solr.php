<?php

function solr_clear_index($url) {
  $clear = $url . '/update?stream.body=<delete><query>*:*</query></delete>';
  if (solr_curl_request($clear)) {
    return solr_commit($url);
  }
  return FALSE;
}

function solr_last_import($url) {
  $url .= '/admin/file?file=dataimport.properties';
  return solr_curl_request($url);
}

function solr_commit($url) {
  $url .= '/update?stream.body=<commit/>';
  return solr_curl_request($url);
}

function solr_query($url) {
  $url .= '/select/?q=*%3A*&version=2.2&start=0&rows=30&indent=on';
  return solr_curl_request($url);
}

function solr_ping($url) {
  $url .= '/admin/ping';
  return solr_curl_request($url);
}

function solr_import_full($url) {
  $url .= '/dataimport?command=full-import';
  return solr_curl_request($url);
}

//https://wiki.apache.org/solr/DataImportHandler#Using_delta-import_command
function solr_import_delta($url) {
  $url .= '/dataimport?command=delta-import';
  return solr_curl_request($url);
}

function solr_import_delta_foo($url, $foo) {
  $url .= '/dataimport?command=delta-import&foo=' . $foo;
  return solr_curl_request($url);
}

function solr_curl_request($url) {
  try {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    if ($response = curl_exec($ch)) {
      $info = curl_getinfo($ch);
    }
    curl_close($ch);
    if ($response == FALSE) {
      $error = curl_error($ch);
      echo sprintf('The Solr server returned false to %s with error %s. <br />', $url, $error
      );
      return FALSE;
    }
    if ($info['http_code'] != 200) {
      echo sprintf('The Solr server returned code %d to %s (%s) </ br>.', $info['http_code'], $url, $info['content_type']
      );
      return FALSE;
    }
    return $response;
  } catch (Exception $e) {
    echo $e->getMessage();
    //echo $e->getTraceAsString();
  }
}