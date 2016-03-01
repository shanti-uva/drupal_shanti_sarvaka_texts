<?php

define('SHANTI_SARVAKA_TEXTS_PATH',drupal_get_path('theme','shanti_sarvaka_texts'));

function shanti_sarvaka_texts_menu_breadcrumb_alter(&$active_trail, $item) 
{
	if ($active_trail[0]['title'] == 'Home') 
	{
		array_shift($active_trail);
	}
}

function shanti_sarvaka_texts_form_alter(&$form, $form_state, $form_id) 
{
	// Note that $form_id != $form['#id']
	if ($form_id == 'views_exposed_form' && preg_match('/^views-exposed-form-all-texts/', $form['#id'])) 
	{
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

function shanti_sarvaka_texts_preprocess_node(&$vars) 
{
  if ($vars['type'] == 'book' && $vars['teaser'] == FALSE) 
  {
  
    // If not top of book, redirect to the book
    $nid = $vars['nid'];
    $bid = $vars['book']['bid'];
    if (!$bid) 
    {
    	drupal_set_message("This is not a book!"); 
	}
    elseif ($bid != $nid) 
    { 
		$s = '';
		if (array_key_exists('s',$_GET)) { $s = $_GET['s']; }
		drupal_goto("node/$bid", array('query' => array('s' => $s), 'fragment' => "book-node-$nid")); 
	}
    $top_mlid = $vars['book']['p1'];

    // Highlight search hits
    if (isset($_GET['s']) && !preg_match("/^\s*$/",$_GET['s'])) 
    {
      $s = $_GET['s'];
      $book_body_rendered = preg_replace_callback(
        "/($s)/i",
        function($match) use (&$count) 
        {
          $count++; 
          return "<span id='shanti-texts-search-hit-{$count}' "
            . "class='shanti-texts-search-hit'>$match[1]</span>";
        },
        $book_body_rendered,-1,$count
      );
    }
    
	// Build the render array for the page
    $vars['content']['shanti_texts_container'] = array(
      '#type' => 'container',
      '#attributes' => array('id' => 'shanti-texts-container'),
    );
    $vars['content']['shanti_texts_container']['body'] = array(
      '#type'   => 'markup',
      '#prefix' => '<div id="shanti-texts-body">',
      '#markup' => views_embed_view('single_text_body',	'panel_pane_default',$bid),
      '#suffix' => '</div>',
    );
    $vars['content']['shanti_texts_container']['sidebar'] = array(
      '#type' => 'container',
      '#attributes' => array('id' => 'shanti-texts-sidebar', 'role' => 'tabpanel'), // Set to hidden in CSS 
    );
    $vars['content']['shanti_texts_container']['sidebar']['tabs'] = array(
      '#type' => 'ul',  
      '#theme' => 'item_list',
      '#attributes' => array('id' => 'shanti-texts-sidebar-tabs', 'role' => 'tablist', 'class' => array('nav','nav-tabs','nav-justified')),
      '#items' => array(
        array('class' => '', 'role' => 'presentation', 'data' => '<a href="#shanti-texts-toc" role="tab" data-toggle="tab" aria-expanded="true">Contents</a>'),
        array('class' => '', 'role' => 'presentation', 'data' => '<a href="#shanti-texts-meta" role="tab" data-toggle="tab">Description</a>'),
        array('class' => '', 'role' => 'presentation', 'data' => '<a href="#shanti-texts-links" role="tab" data-toggle="tab">Views</a>'),
      ),
    );
    $vars['content']['shanti_texts_container']['sidebar']['tabcontent'] = array(
      '#type' => 'container',
      '#attributes' => array('class' => array('tab-content')),
    );
    $vars['content']['shanti_texts_container']['sidebar']['tabcontent']['toc'] = array(
      '#type'   => 'markup',
      '#prefix' => '<div role="tabpanel" class="tab-pane" id="shanti-texts-toc">',
      '#markup' => views_embed_view('single_text_toc', 'panel_pane_default',$bid),
      '#suffix' => '</div>',
    );
    $vars['content']['shanti_texts_container']['sidebar']['tabcontent']['meta'] = array(
      '#type'   => 'markup',
      '#prefix' => '<div role="tabpanel" class="tab-pane" id="shanti-texts-meta">',
      '#markup' => views_embed_view('single_text_meta', 'panel_pane_default',$bid), 
      '#suffix' => '</div>',
    );
    $vars['content']['shanti_texts_container']['sidebar']['tabcontent']['links'] = array(
      '#type' 	=> 'markup',
      '#prefix' => '<div role="tabpanel" class="tab-pane" id="shanti-texts-links">',
      '#markup' => views_embed_view('single_text_views', 'panel_pane_default',$bid),
      '#suffix' => '</div>',
    );
    
    // Add CSS and JS
    $js_settings = array(
      'book'        => $vars['book'],
      'book_title'  => $vars['book']['link_title'],
      'kwic_n'      => isset($_GET['n']) ? $_GET['n'] : 0,  
      'edit_rights'	=> user_access('add content to books') && user_access('create new books'),
    );
    
    $vars['content']['shanti_texts_container']['#attached'] = array(
      'js' => array(
        SHANTI_SARVAKA_TEXTS_PATH . '/js/shanti_texts.js' => array('type' => 'file'),
        SHANTI_SARVAKA_TEXTS_PATH . '/js/jquery.localscroll.min.js' => array('type' => 'file'),
        SHANTI_SARVAKA_TEXTS_PATH . '/js/jquery.scrollTo.min.js' => array('type' => 'file'),
        array('data' => array('shantiTexts' => $js_settings), 'type' => 'setting'),
      ),                                                     
      'css' => array(
        SHANTI_SARVAKA_TEXTS_PATH . '/css/shanti_texts.css',
        SHANTI_SARVAKA_TEXTS_PATH . '/css/shanti_texts_footnotes.css',
      ),
    );
 
    // Remove things we don't want to see
    foreach(array_keys($vars['content']) as $k) {
      if ($k != 'shanti_texts_container') {
        unset($vars['content'][$k]);
      }      
    }

    // NOT SURE WHY THIS IS HERE
    unset($vars['submitted']);
    
  }
}

function shanti_sarvaka_texts_preprocess_views_view(&$vars) {}
