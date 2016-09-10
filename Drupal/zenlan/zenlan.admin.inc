<?php

function zenlan_form1($form, array &$form_state) {

  $parent['#tree'] = TRUE;
  $parent['#description'] = t('Parent');
  $parent['subform1'] = array(
      '#type' => 'fieldset',
      '#title' => t('SubForm1'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
  );
  $parent['subform1']['id'] = array(
      '#type' => 'textfield',
      '#title' => t('ID'),
      '#value' => 0,
      '#size' => 2,
  );
  $parent['subform1']['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#value' => '',
      '#size' => 32,
  );

  $parent['subform2'] = array(
      '#type' => 'fieldset',
      '#title' => t('SubForm2'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
      'table' => drupal_get_form('zenlan_table1', 'subform2'),
      'add' => array(
          '#type' => 'button',
          '#value' => t('add'),
          '#prefix' => '',
          '#attributes' => array(
              'onclick' => 'javascript:window.location.href="/admin/thing/add/table1/"; return false;'
          ),
      ),
  );

  $parent['subform3'] = array(
      '#type' => 'fieldset',
      '#title' => t('SubForm3'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
      'table' => drupal_get_form('zenlan_table2', 'subform3'),
      'add' => array(
          '#type' => 'button',
          '#value' => t('add'),
          '#prefix' => '',
          '#attributes' => array(
              'onclick' => 'javascript:window.location.href="/admin/thing/add/table2/"; return false;'
          ),
      ),
  );

  $parent['submit'] = array(
      '#type' => 'submit',
      '#value' => 'Save',
  );
  return $parent;
}

function zenlan_table2($form, array &$form_state) {
  $form['#tree'] = TRUE;
  $form['#attributes'] = array('id' => 'form-edit-table2');
  $header = array(
      array(
          'data' => 'Weight',
          'type' => 'property',
          'specifier' => 'weight',
      ),
      array(
          'data' => 'Fieldset',
          'type' => 'field',
          'specifier' => 'fieldset',
      ),
  );
  $data = array(
      array(
          'weight' => 1,
          'id' => 1,
          'fieldset' => '',
      ),
      array(
          'weight' => 2,
          'id' => 2,
          'fieldset' => '',
      ),
  );
  $form['#header'] = $header;
  foreach ($data as $row) {
    foreach ($header as $column) {
      if ($column['specifier'] == 'fieldset') {
        $subform = drupal_get_form('zenlan_fieldset1', array('id' => $row['id']));
        $form['rows'][$row['weight']][$column['specifier']] = array(
            '#type' => 'item',
            '#markup' => drupal_render($subform),
        );
      } else {
        $form['rows'][$row['weight']][$column['specifier']] = array(
            '#type' => 'item',
            '#markup' => $row[$column['specifier']],
        );
      }
    }
  }
  sort($form['rows']);
  return $form;
}

function zenlan_fieldset1($form, array &$form_state, $data) {
  $form['#tree'] = TRUE;
  $form['#attributes'] = array('id' => 'form-edit-fieldset' . $data['id']);
  $form['set'] = array(
      '#type' => 'fieldset',
      '#title' => t('Fieldset') . ': ' . $data['id'],
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
  );
  $form['set']['id'] = array(
      '#type' => 'textfield',
      '#title' => t('ID'),
      '#default_value' => $data['id'],
      '#size' => 2,
  );
  $form['set']['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#default_value' => 'Title ' . $data['id'],
      '#size' => 32,
  );
  $form['set']['delete'] = array(
      '#type' => 'button',
      '#value' => t('delete'),
      '#prefix' => '',
      '#attributes' => array(
          'onclick' => 'javascript:window.location.href="/admin/thing/delete/table2/"; return false;'
      ),
  );
  return $form;
}

function zenlan_table1($form, array &$form_state) {
  $form['#tree'] = TRUE;
  $form['#attributes'] = array('id' => 'form-edit-table1');
  $header = array(
      array(
          'data' => 'Weight',
          'type' => 'property',
          'specifier' => 'weight',
      ),
      array(
          'data' => 'Actions',
          'type' => 'field',
          'specifier' => 'action',
      ),
      array(
          'data' => 'ID',
          'type' => 'field',
          'specifier' => 'id',
      ),
      array(
          'data' => 'Title',
          'type' => 'field',
          'specifier' => 'title',
      ),
  );
  $data = array(
      array(
          'weight' => 1,
          'id' => 1,
          'action' => l('edit', 'admin/table1/edit/1') . ' ' . l('delete', 'admin/table1/delete/1'),
          'title' => 'Title 1',
      ),
      array(
          'weight' => 2,
          'id' => 2,
          'action' => l('edit', 'admin/table1/edit/2') . ' ' . l('delete', 'admin/table1/delete/2'),
          'title' => 'Title 2',
      ),
  );
  $form['#header'] = $header;
  foreach ($data as $row) {
    foreach ($header as $column) {
      $form['rows'][$row['weight']][$column['specifier']] = array(
          '#type' => 'item',
          '#markup' => $row[$column['specifier']],
      );
    }
  }
  sort($form['rows']);
  return $form;
}

function zenlan_info(array $form, array &$form_state) {

  $description = '<strong>Uses Hooks:</strong><br /><br />';
  $hooks = array(
      'entity_info',
      'entity_property_info',
      'cron',
      'cron_queue_info',
      'menu',
      'permission',
      'search_api_service_info',
      'theme',
      'tokens',
      'token_info',
      'token_values',
      'tokens_alter',
      'views_api',
      'views_plugins',
  );
  foreach ($hooks as $hook) {
    $result = module_hook('zenlan', $hook);
    $description.= print_r($hook, true) . ' : ' . ($result ? 'true' : 'false') . '<br />';
  }
  $form['description'] = array(
      '#markup' => $description,
  );
  return $form;
}

function zenlan_entity1($form, array &$form_state) {
  $form['#tree'] = TRUE;
  $form['#description'] = t('Entity');

  $form['submitAid'] = array(
      '#type' => 'submit',
      '#value' => 'load zentity1_a by id',
      '#submit' => array('zenlan_entity1ai_test_submit'),
  );
  $form['submitBid'] = array(
      '#type' => 'submit',
      '#value' => 'load zentity1_b by id',
      '#submit' => array('zenlan_entity1bi_test_submit'),
  );
  $form['submitAvals'] = array(
      '#type' => 'submit',
      '#value' => 'load zentity1_a with vals',
      '#submit' => array('zenlan_entity1av_test_submit'),
  );
  $form['submitBvals'] = array(
      '#type' => 'submit',
      '#value' => 'load zentity1_b with vals',
      '#submit' => array('zenlan_entity1bv_test_submit'),
  );
  $form['submitAerr'] = array(
      '#type' => 'submit',
      '#value' => 'load zentity1_a with error',
      '#submit' => array('zenlan_entity1ae_test_submit'),
  );
  $form['submitBerr'] = array(
      '#type' => 'submit',
      '#value' => 'load zentity1_b with error',
      '#submit' => array('zenlan_entity1be_test_submit'),
  );
  return $form;
}

function zenlan_entity1ai_test_submit($form, $form_state) {
  $result = entity_load('zentity1_a', array(1));
  drupal_set_message(print_r($result, 1));
}

function zenlan_entity1bi_test_submit($form, $form_state) {
  $result = entity_load('zentity1_b', array(1));
  drupal_set_message(print_r($result, 1));
}

function zenlan_entity1av_test_submit($form, $form_state) {
  $result = entity_load('zentity1_a', array(array('id' => 1, 'title' => 'Test 1', 'title_b' => 'Test 1A')));
  drupal_set_message(print_r($result, 1));
}

function zenlan_entity1bv_test_submit($form, $form_state) {
  $result = entity_load('zentity1_b', array(array('id' => 1, 'title' => 'Test 1', 'title_b' => 'Test 1B')));
  drupal_set_message(print_r($result, 1));
}

function zenlan_entity1ae_test_submit($form, $form_state) {
  $result = entity_load('zentity1_a', array('a'));
  drupal_set_message(print_r($result, 1));
}

function zenlan_entity1be_test_submit($form, $form_state) {
  $result = entity_load('zentity1_b', array('b'));
  drupal_set_message(print_r($result, 1));
}

function zenlan_autocomplete1($form, array &$form_state) {
  $form['#tree'] = TRUE;
  $form['#description'] = t('Autocomplete (custom)');

  $form['id'] = array(
      '#title' => 'ID',
      '#type' => 'textfield',
      '#default_value' => '',
      '#attributes' => array(
          'id' => 'edit-id',
      )
  );
  $form['name'] = array(
      '#title' => 'Name',
      '#type' => 'textfield',
      '#default_value' => '',
      '#attributes' => array(
          'id' => 'edit-name',
      )
  );
  drupal_add_css('//code.jquery.com/ui/1.8.24/themes/base/jquery-ui.css', 'external');
  drupal_add_js('//code.jquery.com/ui/1.8.24/jquery-ui.js', 'external');
  $path = drupal_get_path('module', 'zenlan');
  drupal_add_js($path . '/js/jquery.base64.js');
  drupal_add_js($path . '/js/zenlan-autocomplete.js');
  drupal_add_js(array('zenlan' => array('api_url' => base_path() . 'zenlan/ac1/')), 'setting');
  return $form;
}

function zenlan_autocomplete2($form, array &$form_state) {
  $form['#tree'] = TRUE;
  $form['#description'] = t('Autocomplete (native)');

  $form['name'] = array(
      '#title' => 'Name',
      '#type' => 'textfield',
      '#default_value' => '',
      '#autocomplete_path' => 'zenlan/ac2',
//      '#autocomplete_path' => 'user/autocomplete',
//      '#attributes' => array(
//          'id' => 'edit-name',
//      )
  );
  return $form;
}
