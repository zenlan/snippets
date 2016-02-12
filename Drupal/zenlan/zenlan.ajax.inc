<?php

function zenlan_ajax1($form, &$form_state) {
  $form = array();
  $form['intro'] = array(
    '#type' => 'markup',
    '#markup' => t("<div>Demonstrates how AJAX commands can be used.</div>"),
  );
  $form['field1'] = array(
      '#type' => 'textfield',
      '#value' => '',
      '#attributes' => array(
          'id' => 'field1',
//          'data-1' => 'foo',
      ),
  );
  $form['submit'] = array(
    '#value' => t("AJAX 'data': Click to change value"),
    '#type' => 'submit',
    '#ajax' => array(
      'callback' => 'zenlan_ajax_data_callback',
    ),
  );
  return $form;
}

/**
 * Callback for 'data'.
 *
 * @see ajax_command_data()
 */
function zenlan_ajax_data_callback($form, $form_state) {
  drupal_add_js(drupal_get_path('module', 'zenlan') . '/js/zenlan-ajax1.js');
  drupal_add_js(array(
      'zenlan' => array(
          'value' => 'foo',
      ),
          ), 'setting');  
//  $commands[] = ajax_command_data('#field1', 'foo', 'bar');  
  $commands = array();
  return array('#type' => 'ajax', '#commands' => $commands);
}


