<?php

// Get items for use in the Carousel
// We make a direct query to the db to grab items that have been promoted
// to the front page, taking advantage of this legacy field for our own
// purposes.
$items = array();
$sql = "SELECT n.nid FROM {book} b JOIN {node} n USING (nid) WHERE b.nid = b.bid AND n.promote = 1 AND n.status = 1 ORDER BY n.changed DESC LIMIT 0,5";
$rs = db_query($sql);
while ($r = $rs->fetchObject()) {
	$this_node = node_load($r->nid);
	$lang = $this_node->language;
	$authors = array();
	foreach($this_node->field_book_author[$lang] as $auth) {
		$authors[] = $auth['value'];
	}	
	$desc = $this_node->field_dc_description[$lang][0]['value'];
	$img_url = image_style_url('front_carousel', $this_node->field_general_featured_image[$lang][0]['uri']);	
	$items[] = array(
		'node_url'	=> url("node/".$r->nid),
		'title' 		=> $this_node->title,
		'authors' 	=> implode(',', $authors),
		'orig_date' => sizeof($this_node->field_dc_date_orginial_year) > 0 ? preg_replace("/^\s*(....)-.+/","$1", $this_node->field_dc_date_orginial_year[$lang][0]['value']) : '',
		'pub_date' 	=> preg_replace("/^\s*(....)-.+/","$1", $this_node->field_dc_date_publication_year[$lang][0]['value']),
		'desc' 			=> $desc,
		'img_url' 	=> $img_url,
	);
}
?>

<div class="front-overview">
	<p>SHANTI Texts is a published repository of texts that can be used for a variety of content types, from remediated 
	primary sources to long-form scholarly blog posts to be shared via social media. It is designed to allow you create 
	content on-site or to upload long texts.</p>
</div>
<div class="container-fluid carouseldiv">
	<div class="row">
		<div class="col-xs-12">
			<div class="carousel carousel-fade slide row" id="collection-carousel" data-speed="12">
				<div class="carousel-inner">
				<?php foreach($items as $i => $item): ?>
					<div class="item <?php if ($i == 0) { print 'active'; } ?>">
						<div class="carousel-main-content col-xs-12 col-sm-7 col-md-8">
							<div>
								<h3 class="carousel-title">
									<a href="<?php echo $item['node_url'] ?>">
										<span class="icon shanticon-texts"></span>
										<?php echo $item['title'] ?>
									</a>
								</h3>
							</div>
							<div class="byline">
								<?php echo $item['authors'] . " "; ?> 
								<?php echo $item['pub_date'] . " "; ?> 
								<?php if (preg_match("/^....$/", $item['orig_date'])) { echo '('.$item['orig_date'].')'; }?>								
							</div>
							<div class="carousel-description">
								<div class="field field-name-body field-type-text-with-summary field-label-hidden">
									<?php echo $item['desc'] ?>
								</div>
							</div>
						</div>
						<div class="carousel-main-image col-xs-12 col-sm-5 col-md-4">
							<a href="<?php echo $item['node_url'] ?>">
								<img src="<?php echo $item['img_url'] ?>" alt="">
							</a>
						</div>
					</div>				
				<?php endforeach; ?>
				</div>
				<div class="control-box">
					<a data-slide="prev" href="#collection-carousel" class="carousel-control left"><span class="icon"></span></a>
					<a data-slide="next" href="#collection-carousel" class="carousel-control right"><span class="icon"></span></a>
				</div>
				<div class="control-box-2">
					<button class="btn btn-default btn-sm carousel-pause">
						<span class="glyphicon glyphicon-pause"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div>
<?php 
	$view = views_get_view('all_texts');
	$view->override_path = $_GET['q'];
	$viewsoutput = $view->preview('panel_pane_1');
	print $viewsoutput;
?>
</div>