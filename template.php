<?php

define('SHANTI_SARVAKA_TEXTS_PATH',drupal_get_path('theme','shanti_sarvaka_texts'));

function shanti_sarvaka_texts_form_alter(&$form, $form_state, $form_id) {
<<<<<<< HEAD
	// Note that $form_id != $form['#id']
	$my_form_ids = array('views-exposed-form-all-texts-panel-pane-1','views-exposed-form-all-texts-page-1');
	if ($form_id == 'views_exposed_form' && in_array($form['#id'], $my_form_ids)) {
=======
	if ($form_id == 'views_exposed_form' && $form['#id'] == 'views-exposed-form-all-texts-panel-pane-1') {
>>>>>>> 586c28dfef821f544b2097534200dc58d3d8ed67
		$form['title'] += array(
			'#attributes' => array(
				'placeholder' => 'Search by Title',
			),
		);
		$form['field_book_author_value'] += array(
			'#attributes' => array(
				'placeholder' => 'Search by Author',
			),
		);
	}
}

function shanti_sarvaka_texts_preprocess_views_view(&$vars) {

	// Note this will fail, since I am testing a new version (see elseif below ...)
  if (isset($vars['view']->name) && $vars['view']->name == 'all_texts_FOO') {
  
    // Grab the pieces you want and then remove them from the array    
    $header   = $vars['header'];    $vars['header']   = '';
    $filters  = $vars['exposed'];   $vars['exposed']  = '';
    $pager    = $vars['pager'];     $vars['pager']    = '';
    
    $control_box = array(
      '#type' => 'container',
      '#attributes' => array('class' => array('view-all-texts-control-box')),
      'control_box_row' => array(
        '#type' => 'container',
        '#attributes' => array('class' => array('view-all-texts-control-box-row row')),
        'header' => array(
          '#markup' => $header,
          '#prefix'  => "<div class='view-all-texts-control-box-cell-header view-all-texts-control-box-cell col-xs-12 col-md-4'>",
          '#suffix' => "</div>",        
        ),
        'filters' => array(
          '#markup' => $filters,
          '#prefix'  => "<div class='view-all-texts-control-box-cell-filters view-all-texts-control-box-cell col-xs-12 col-md-4'>",
          '#suffix' => "</div>",        
        ),
        'switch_list' => array(
            '#prefix'  => "<div class='view-all-texts-control-box-cell-switch view-all-texts-control-box-cell col-xs-12 col-md-2'>",
            '#suffix' => "</div>",        
            '#theme' => 'item_list',
            '#type'  => 'ul',
            '#attributes' => array('id' => 'view-all-texts-switcher'),
            '#items' => array(
              array(
                'class' => array('fat-list'),
                'data'  => "<span id='view-all-texts-fat-list' class='icon shanticon-list'></span>",
              ), 
              array(
                'class' => array('thin-list'),
                'data'  => "<span id='view-all-texts-thin-list' class='icon shanticon-list4'></span>",              
              ),
              array(
                'class' => array('grid'),
                'data'  => "<span id='view-all-texts-grid' class='icon shanticon-grid'></span>",              
              ),
            ),
          ),
        'pager' => array(
          '#markup' => $pager,
          '#prefix' => "<div class='view-all-texts-control-box-cell-pager view-all-texts-control-box-cell col-xs-12 col-md-4'>",
          '#suffix' => "</div>",
        ),
      ),
    );
    
    $control_box['#attached']['js'] = array(
      SHANTI_TEXTS_PATH . '/js/jquery.transit.min.js',
      SHANTI_SARVAKA_TEXTS_PATH . '/js/jquery.cookie.js',
      SHANTI_SARVAKA_TEXTS_PATH . '/js/shanti_texts_page_all_texts.js',
    );

    $control_box['#attached']['css'] = array(
      SHANTI_SARVAKA_TEXTS_PATH . '/css/shanti_texts_page_all_texts.css'    
    );

    // Attach the new element to the array
    $vars['attachment_before'] = drupal_render($control_box);
    $vars['attachment_after']  = $pager;

  }
  
  // This is now the main thing ...
  elseif (isset($vars['view']->name) && $vars['view']->name == 'all_texts') {
  
    // Grab the pieces you want and then remove them from the array    
    $header   = $vars['header'];    $vars['header']   = '';
    $filters  = $vars['exposed'];   $vars['exposed']  = '';
    $pager    = $vars['pager'];     $vars['pager']    = '';
    
    $control_box = array(
      '#type' => 'container',
      '#attributes' => array('class' => array('view-all-texts-control-box')),
      'control_box_row' => array(
        '#type' => 'container',
        '#attributes' => array('class' => array('view-all-texts-control-box-row row')),
        'header' => array(
          '#markup' => $header,
          '#prefix'  => "<div class='view-all-texts-control-box-cell-header view-all-texts-control-box-cell  col-xs-12 col-md-4'>",
          '#suffix' => "</div>",        
        ),
        'filters' => array(
          '#markup' => $filters,
          '#prefix'  => "<div class='view-all-texts-control-box-cell-filters view-all-texts-control-box-cell  col-xs-12 col-md-4'>",
          '#suffix' => "</div>",        
        ),
        'pager' => array(
          '#markup' => $pager,
          '#prefix' => "<div class='view-all-texts-control-box-cell-pager view-all-texts-control-box-cell  col-xs-12 col-md-4'>",
          '#suffix' => "</div>",
        ),
      ),
    );
    
    $control_box['#attached']['js'] = array();

    $control_box['#attached']['css'] = array(
      SHANTI_SARVAKA_TEXTS_PATH . '/css/shanti_texts_page_all_texts.css'    
    );

    // Attach the new element to the array
    $vars['attachment_before'] = drupal_render($control_box);
    $vars['attachment_after']  = $pager;
  
  }


}
