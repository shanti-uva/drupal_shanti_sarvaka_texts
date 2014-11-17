<?php

define('SHANTI_SARVAKA_TEXTS_PATH',drupal_get_path('theme','shanti_sarvaka_texts'));

function shanti_sarvaka_texts_preprocess_views_view(&$vars) {

  if (isset($vars['view']->name) && $vars['view']->name == 'all_texts') {
    // Grab the pieces you want and then remove them from the array    
    $header   = $vars['header'];    $vars['header']   = '';
    $filters  = $vars['exposed'];   $vars['exposed']  = '';
    $pager    = $vars['pager'];     $vars['pager']    = '';
    
    // Should be a render array
    
    // Create the view layout switcher
    $btn1 = "<span class='icon shanticon-list'></span>";
    $btn2 = "<span class='icon shanticon-list4'></span>";
    $btn3 = "<span class='icon shanticon-grid'></span>";
    $switch = "<ul id='view-all-texts-switcher'><li class='fat-list'>$btn1</li><li class='thin-list'>$btn2</li><li class='grid'>$btn3</li></ul>";
    
    // Put everything in a new element
    $control_box = "<div class='view-all-texts-control-box'><div class='view-all-texts-control-box-row'><span class='a view-all-texts-control-box-cell'>$header</span><span class='b view-all-texts-control-box-cell'>$filters</span><span class='c view-all-texts-control-box-cell'>$switch</span><span class='d view-all-texts-control-box-cell'>$pager</span></div></div>\n";
    
    // Attach the new element to the array
    $vars['attachment_before'] = $control_box;
    $vars['attachment_after'] = $pager;
    
    // Add JS and CSS files that will take over behavior
    drupal_add_js(SHANTI_ESSAYS_PATH . '/js/jquery.transit.min.js', 'file');
    drupal_add_js(SHANTI_SARVAKA_TEXTS_PATH . '/js/jquery.cookie.js', 'file');
    drupal_add_js(SHANTI_SARVAKA_TEXTS_PATH . '/js/shanti_essays_page_all_texts.js', $type = 'file', $media = 'all', $preprocess = FALSE);
    drupal_add_css(SHANTI_SARVAKA_TEXTS_PATH . '/css/shanti_essays_page_all_texts.css', $type = 'file', $media = 'all', $preprocess = FALSE);
  
  }
}
