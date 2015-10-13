<?php
$results = array();
session_start();

include('sql.php');
include('solr.php');

if (isset($_POST['btn-database'])) {
  $_SESSION['db'] = $_POST;
}

if (isset($_SESSION['db'])) {
  try {
    $mdbh = new PDO('mysql:host=' . $_SESSION['db']['hostname'] . ';dbname=' . $_SESSION['db']['database'], $_SESSION['db']['username'], $_SESSION['db']['password']);
    if (!$mdbh) {
      $results[] = print_r($mdbh->errorInfo(), 1);
    } else {
      $results[] = 'Connected to database: OK';
    }
  } catch (PDOException $e) {
    print $e->getMessage();
    exit();
  }
  if (isset($_POST['test_solr_b_del']) && $mdbh) {
    try {
      $res = $mdbh->exec($exec['delete_solr_b'] . $_POST['id']);
    } catch (PDOException $e) {
      print $e->getMessage();
      exit();
    }
  }
  if (isset($_POST['test_solr_b_upd']) && $mdbh) {
    try {
      $res = $mdbh->exec($exec['update_solr_b'] . $_POST['id']);
    } catch (PDOException $e) {
      print $e->getMessage();
      exit();
    }
  }
  if (isset($_POST['test_solr_b_add']) && $mdbh) {
    try {
      $res = $mdbh->exec($exec['insert_solr_b']);
    } catch (PDOException $e) {
      print $e->getMessage();
      exit();
    }
  }
  if (isset($_POST['test_solr_b_del_foo']) && $mdbh) {
    try {
      $res = $mdbh->exec($exec['delete_solr_b'] . $_POST['id']);
      $res = json_decode(solr_import_delta_foo($_SESSION['solr']['url'], $_POST['foo']));
      $last_index =  nl2br(solr_last_import($_SESSION['solr']['url']));  
      $solrres = json_decode(solr_query($_SESSION['solr']['url']));
      $_SESSION['solr']['data'] = $solrres->response->docs;
    } catch (PDOException $e) {
      print $e->getMessage();
      exit();
    }
  }
  if (isset($_POST['test_solr_b_upd_foo']) && $mdbh) {
    try {
      $res = $mdbh->exec($exec['update_solr_b'] . $_POST['id']);
      $res = json_decode(solr_import_delta_foo($_SESSION['solr']['url'], $_POST['foo']));
      $last_index =  nl2br(solr_last_import($_SESSION['solr']['url']));  
      $solrres = json_decode(solr_query($_SESSION['solr']['url']));
      $_SESSION['solr']['data'] = $solrres->response->docs;
    } catch (PDOException $e) {
      print $e->getMessage();
      exit();
    }
  }
  if (isset($_POST['test_solr_b_add_foo']) && $mdbh) {
    try {
      $res = $mdbh->exec($exec['insert_solr_b']);
      $res = json_decode(solr_import_delta_foo($_SESSION['solr']['url'], $_POST['foo']));
      $last_index =  nl2br(solr_last_import($_SESSION['solr']['url']));  
      $solrres = json_decode(solr_query($_SESSION['solr']['url']));
      $_SESSION['solr']['data'] = $solrres->response->docs;
    } catch (PDOException $e) {
      print $e->getMessage();
      exit();
    }
  }  
  if (isset($_POST['btn-tables']) && $mdbh) {
    foreach ($exec['create_tables'] as $sql) {
      try {
        $res = $mdbh->exec($sql);
        $results[] = $sql;
      } catch (PDOException $e) {
        print $e->getMessage();
        exit();
      }
    }
    try {
      $res = $mdbh->exec($exec['insert_solr_a']);
      $res = $mdbh->exec($exec['insert_solr_b']);
      $res = $mdbh->exec($exec['insert_solr_b']);
    } catch (PDOException $e) {
      print $e->getMessage();
      exit();
    }
  }
  try {
    $res = $mdbh->query($qry['test_solr_a']);
    $_SESSION['db']['data']['test_solr_a'] = $res->fetchAll();
    $res = $mdbh->query($qry['test_solr_b']);
    $_SESSION['db']['data']['test_solr_b'] = $res->fetchAll();
  } catch (PDOException $e) {
    print $e->getMessage();
    exit();
  }
}

if (isset($_POST['btn-solr'])) {
  $_SESSION['solr'] = $_POST;
  $_SESSION['solr']['url'] = $_SESSION['solr']['host'] . ':' . $_SESSION['solr']['port'] . $_SESSION['solr']['path'];
  $_SESSION['solr']['data'] = array();
}

if (isset($_SESSION['solr'])) {
  try {
    $ping = json_decode(solr_ping($_SESSION['solr']['url']));
    $results[] = 'Connected to Solr index: ' . $ping->status;
  } catch (Exception $e) {
    print $e->getMessage();
    exit();
  }
  if (isset($_POST['btn-import-full'])) {
    try {
      $res = json_decode(solr_import_full($_SESSION['solr']['url']));
    } catch (Exception $e) {
      print $e->getMessage();
      exit();
    }
  }
  if (isset($_POST['btn-import-delta'])) {
    try {
      $res = json_decode(solr_import_delta($_SESSION['solr']['url']));
    } catch (Exception $e) {
      print $e->getMessage();
      exit();
    }
  }
  if (isset($_POST['btn-clear'])) {
    try {
      $res = json_decode(solr_clear_index($_SESSION['solr']['url']));
    } catch (Exception $e) {
      print $e->getMessage();
      exit();
    }
  }
  $last_index =  nl2br(solr_last_import($_SESSION['solr']['url']));  
  $solrres = json_decode(solr_query($_SESSION['solr']['url']));
  $_SESSION['solr']['data'] = $solrres->response->docs;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Solr Entity Test</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='styles.css' rel='stylesheet' type='text/css'>
  </head>
  <body>    
    <h2>Solr Entity Test</h2>
    <div>
      <form method="POST">
        <table>
          <caption>database</caption>          
          <tr><td class="label">hostname</td><td><input name="hostname" type="text" value="<?php echo (isset($_SESSION['db']) ? $_SESSION['db']['hostname'] : 'localhost'); ?>" /></td></tr>
          <tr><td class="label">database</td><td><input name="database" type="text" value="<?php echo (isset($_SESSION['db']) ? $_SESSION['db']['database'] : 'test'); ?>" /></td></tr>
          <tr><td class="label">username</td><td><input name="username" type="text" value="<?php echo (isset($_SESSION['db']) ? $_SESSION['db']['username'] : 'root'); ?>" /></td></tr>
          <tr><td class="label">password</td><td><input name="password" type="password" value="<?php echo (isset($_SESSION['db']) ? $_SESSION['db']['password'] : ''); ?>" /></td></tr>
        </table>
        <p><button name="btn-database">db: connect</button></p>    
        <!--      </form>
            </div>
            <div>
              <form method="POST">-->
        <p><button name="btn-tables">db: create tables</button></p>    
      </form>
    </div>
    <div class="data">
      <table>
        <caption>table: test_solr_a</caption>
        <thead>
          <tr>
            <th>id</th>
            <th>name</th>
            <th>updated</th>
          </tr>
        </thead>
        <?php
        foreach ($_SESSION['db']['data']['test_solr_a'] as $row) {
          ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['updated']; ?></td>
          </tr>
          <?php
        }
        ?>
      </table>
      <table>
        <caption>table: test_solr_b</caption>
        <thead>
          <tr>
            <th>id</th>
            <th>a_id</th>
            <th>name</th>
            <th>updated</th>
            <th>actions</th>
          </tr>
        </thead>
        <?php
        foreach ($_SESSION['db']['data']['test_solr_b'] as $row) {
          ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['a_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['updated']; ?></td>
            <td>
              <form method="POST">
                <button name="test_solr_b_del">delete</button>
                <button name="test_solr_b_del_foo">delete foo</button>
                <button name="test_solr_b_upd">update</button>
                <button name="test_solr_b_upd_foo">update foo</button>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
                <input type="hidden" name="foo" value="<?php echo $row['a_id']; ?>"/>
              </form>
            </td>
          </tr>
          <?php
        }
        ?>
      </table>
      <form method="POST">
        <button name="test_solr_b_add">db: add another relation</button>
        <button name="test_solr_b_add_foo">db: add another relation foo</button>
        <input type="hidden" name="foo" value="1"/>
      </form>
    </div>

    <div>
      <form method="POST">
        <table>
          <caption>solr</caption>
          <tr><td class="label">host</td><td><input name="host" type="text" value="<?php echo (isset($_SESSION['solr']) ? $_SESSION['solr']['host'] : 'localhost'); ?>" /></td></tr>
          <tr><td class="label">port</td><td><input name="port" type="text" value="<?php echo (isset($_SESSION['solr']) ? $_SESSION['solr']['port'] : '8080'); ?>" /></td></tr>
          <tr><td class="label">path</td><td><input name="path" type="text" value="<?php echo (isset($_SESSION['solr']) ? $_SESSION['solr']['path'] : '/solr/snippets'); ?>" /></td></tr>
        </table>
        <p><button name="btn-solr">solr: connect</button></p>    
      </form>
    </div> 
    <div>
      <form method="POST">
        <p>
          <button name="btn-clear">solr: clear</button>
          <button name="btn-fetch">solr: fetch</button>
        </p>    
        <p>
          <button name="btn-import-full">solr: full import</button>
          <button name="btn-import-delta">solr: delta import</button>
        </p>    
      </form>
    </div>
    <div class="data"><?php echo $last_index; ?></div>
    <div class="data">
      <table>
        <caption>index: <?php echo $_SESSION['solr']['url']; ?></caption>
        <thead>
          <tr>
            <th>id</th>
            <th>name</th>
            <th>relations</th>
            <th>updated</th>
            <th>foo</th>
            <th>request</th>            
          </tr>
        </thead>
        <?php
        foreach ($_SESSION['solr']['data'] as $doc) {
          ?>
          <tr>
            <td><?php echo $doc->id; ?></td>
            <td><?php echo $doc->name; ?></td>
            <td><?php echo $doc->relations; ?></td>
            <td><?php echo $doc->updated; ?></td>
            <td><?php echo $doc->foo; ?></td>
            <td><?php echo $doc->request; ?></td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
    <div id="results">
      <?php
      foreach ($results as $msg) {
        ?>
        <p>
          <?php echo $msg; ?>
        </p>
        <?php
      }
      ?>
    </div>
  </body>
</html>