<?php

define('SHANTI_SARVAKA_TEXTS_PATH',drupal_get_path('theme','shanti_sarvaka_texts'));

function shanti_sarvaka_texts_preprocess_views_view(&$vars) {
  if (isset($vars['view']->name) && $vars['view']->name == 'all_texts') {    
    drupal_add_js(SHANTI_SARVAKA_TEXTS_PATH . '/js/shanti_essays_page_all_texts.js', $type = 'file', $media = 'all', $preprocess = FALSE);
    drupal_add_css(SHANTI_SARVAKA_TEXTS_PATH . '/css/shanti_essays_page_all_texts.css', $type = 'file', $media = 'all', $preprocess = FALSE);
  }
}

/*
function shanti_sarvaka_texts_form_views_exposed_form_alter(&$form, &$form_state) {
  $view = &$form_state['view'];
  if ($view->name == 'all_texts') {
    kpr($form);
    kpr($form_state);
    $form_state['pager_plugin']->options['tags']['previous'] = "FOOBY!";
    if ($view->total_rows == 0) {
      // Hide 'results per page' when the view has no results.
      $form['items_per_page']['#access'] = FALSE;
    }
  }
} 
*/
