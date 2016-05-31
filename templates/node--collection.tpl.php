<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */
 
 $ctypes = variable_get('shanti_collections_admin_content_types');
 $og_field = SHANTI_COLLECTIONS_ADMIN_OG_FIELD;
 $og_parent_field = SHANTI_COLLECTIONS_ADMIN_OG_PARENT_FIELD;
 $collection_items_view = shanti_collections_admin_get_collection_items_view($node->nid);
 
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

	<!-- TITLE -->
	<div class="col-md-12">
		<?php print render($title_prefix); ?>
		<?php if (!$page): ?>
		<h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
		<?php endif; ?>
		<?php print render($title_suffix); ?>
	</div>

	<!-- LEFT -->
	<div class="col-md-7">
		<!-- CONTENT -->
 		<div class="content"<?php print $content_attributes; ?>>
  			<?php print render($content['field_general_featured_image']); ?>
			<?php print render($content['body']); ?>
  		</div>
	</div>

	<!-- RIGHT -->
	<div class="col-md-5">
  
		<!-- Content creation buttons -->
		<?php foreach($ctypes as $ctype => $use): ?>
    	<?php if ($use):?>
    	<a class="btn btn-primary" href="/node/add/<?php echo $ctype;?>?<?php echo $og_field;?>=<?php echo $node->nid;?>&amp;destination=node/<?php echo $node->nid;?>">Add <?php echo $ctype;?></a>
    	<?php endif;?>
  		<?php  endforeach;?>
  
  		<!-- Subcollection stuff -->
  		<?php if ($type == 'collection'): ?>
  		<a type="button" class="btn btn-primary" href="/node/add/subcollection?<?php echo $og_parent_field;?>=<?php echo $node->nid;?>&amp;destination=node/<?php echo $node->nid;?>">Add Subcollection</a>
  		<h3>Subcollections</h3>
  		<?php print views_embed_view('collections','panel_pane_1',$node->nid); ?>
  		<?php else: ?>
  		<h3>Parent Collection</h3>
  		<div>
		<?php
		$content['field_og_parent_collection_ref'][0]['#markup'] = '<span class="icon shanticon-stack"></span> '.$content['field_og_parent_collection_ref'][0]['#markup'];
		print render($content['field_og_parent_collection_ref']); 
		?>
  		</div>
  		<?php endif; ?>
  		<h3>Members</h3>
	</div>

	<!-- BOTTOM -->
	<div class="col-md-12">
  		<?php print $collection_items_view; ?>
	</div>
</div>
<?php kpr($content); ?>
<?php kpr($node); ?>