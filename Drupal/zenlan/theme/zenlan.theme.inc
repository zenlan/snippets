<?php

function template_preprocess_zenlan_index(&$variables) {
  $options = zenlan_menu();
  $variables['zenlan_index_vars'] = array(
      'menu' => $options,
  );
  return;
}

function template_preprocess_zenlan_page_test(&$variables) {
  $variables['zenlan_page_test_vars'] = array(
      'foo' => 'bar',
  );
  return;
}

/**
 * Returns HTML for the test edit form.
 * @param array $variables * An associative array containing: 
 * - form: The Form API render array. 
 */
function theme_zenlan_form_test($variables) {
  $form = $variables['form'];

  $output = '';
  $form['subform1']['#children'] = drupal_render_children($form['subform1']);
  $output .= theme_fieldset(array('element' => $form['subform1']));

  $output .= _zenlan_subform('subform2', $form);
  $output .= _zenlan_subform('subform3', $form);

  $output .= drupal_render($form['submit']);
  drupal_add_js('misc/tableheader.js');
  drupal_add_js('misc/form.js', 'file');
  drupal_add_js('misc/collapse.js', 'file');

  return $output;
}

function _zenlan_subform($name, $form) {
  $rows = $row = array();
  $table = $form[$name]['table'];
  foreach (element_children($table['rows']) as $key) {
    $row_data = array();
    foreach ($table['#header'] as $column) {
      $row = array();
      if ($column['specifier'] == 'weight') {
        $row['width'] = '5%';
      }
      $row['data'] = drupal_render($table['rows'][$key][$column['specifier']]);
      $row_data[] = $row;
    }
    $rows[] = array('data' => $row_data, 'class' => array('draggable'));
  }
  $form[$name]['#children'] = drupal_render($form[$name]['add']);
  $form[$name]['#children'] .= theme('table', array(
      'attributes' => $table['#attributes'],
      'header' => $table['#header'],
      'rows' => $rows,
          )
  );
  drupal_add_tabledrag($table['#attributes']['id'], 'order', 'sibling', 'form-item', NULL, NULL, FALSE);
  return theme_fieldset(array('element' => $form[$name]));
}