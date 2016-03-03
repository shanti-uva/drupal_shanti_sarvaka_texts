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

function shanti_sarvaka_texts_preprocess_page(&$vars)
{
    #kpr($vars);
    #hide($page['content']['shanti_texts_mega_search']);
    #hide($page['content']['explore_menu_explore_menu_block']);
    #hide($page['content']['menu_menu-test']);
    #print drupal_render($page['content']);   
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
		if (array_key_exists('s',$_GET)) 
		{ 
		    $s = $_GET['s']; 
		}
		drupal_goto("node/$bid", array('query' => array('s' => $s), 'fragment' => "book-node-$nid")); 
	}
    $top_mlid = $vars['book']['p1'];

    // Highlight search hits (a bit of a kludge)
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
     
    // Maybe do stuff based on $vars['view_mode'], e.g. if 'embed'
    if ($vars['view_mode'] == 'embed') 
    {
        // Maybe
    }
    
    // Add CSS and JS
    $js_settings = array(
      'book'        => $variables['book'],
      'book_title'  => $variables['book']['link_title'];,
      'kwic_n'      => isset($_GET['n']) ? $_GET['n'] : 0,  
      'edit_rights'	=> user_access('add content to books') && user_access('create new books'),
    );
    
    drupal_add_js(SHANTI_SARVAKA_TEXTS_PATH . '/js/shanti_texts.js', 'file');
    drupal_add_js(SHANTI_SARVAKA_TEXTS_PATH . '/js/jquery.localscroll.min.js', 'file');
    drupal_add_js(SHANTI_SARVAKA_TEXTS_PATH . '/js/jquery.scrollTo.min.js','file');
    drupal_add_js(array('shantiTexts' => $js_settings), 'setting');
    drupal_add_css(SHANTI_SARVAKA_TEXTS_PATH . '/css/shanti_texts.css');
    drupal_add_css(SHANTI_SARVAKA_TEXTS_PATH . '/css/shanti_texts_footnotes.css');
    
    // Remove things we don't want to see
    foreach(array_keys($variables['content']) as $k) {
      if ($k != 'shanti_texts_container') {
        unset($variables['content'][$k]);
      }      
    }
    
    // NOT SURE WHY THIS IS HERE
    unset($variables['submitted']);

  }
}

function shanti_sarvaka_texts_preprocess_views_view(&$vars) {}
