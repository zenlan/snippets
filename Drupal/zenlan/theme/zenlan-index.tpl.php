<ul>
  <?php
  $zenvars = $variables['zenlan_index_vars'];
  foreach ($zenvars['menu'] as $path => $args) {
    if ($args['type'] !== MENU_CALLBACK) {
      ?>
      <li>
        <?php
        echo l($args['title'], $path);
        ?>
      </li>
      <?php
    }
  }
  ?>
</ul>