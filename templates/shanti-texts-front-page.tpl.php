<?php

// Get items for use in the Carousel
// We make a direct query to the db to grab items that have been promoted
// to the front page, taking advantage of this legacy field for our own
// purposes.
$items = array();
$sql = "SELECT nid FROM {node} WHERE type = 'collection' and promote = 1 AND status = 1";
$rs = db_query($sql);
while ($r = $rs->fetchObject()) {
  $this_node = node_load($r->nid);
  $lang = $this_node->language;
  $desc = $this_node->body[$lang][0]['value'];
  $img_url = image_style_url('front_carousel', $this_node->field_general_featured_image[$lang][0]['uri']);  
  $items[] = array(
    'node_url'  => url("node/".$r->nid),
    'title'   => $this_node->title,
    'desc'    => $desc,
    'img_url'   => $img_url,
  );
}
?><div class="front-overview">
  <p>SHANTI Texts is a published repository of texts that can be used for a variety of content types, from remediated 
  primary sources to long-form scholarly blog posts to be shared via social media. It is designed to allow you create 
  content on-site or to upload long texts.</p>
</div>
<div class="container-fluid carouseldiv">
  <div class="carousel-header show-more" data-ride="carousel"><span>Featured Collections</span><a href="/collections">View All Collections</a></div>
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
                    <span class="icon shanticon-stack"></span>
                    <?php echo $item['title'] ?>
                  </a>
                </h3>
              </div>
              <div class="carousel-description">
                <div class="field field-name-body field-type-text-with-summary field-label-hidden">
                  <?php echo $item['desc'] ?>
                </div>
              </div>
              <p class="show-more h5"><a href="<?php echo $item['node_url']; ?>">View Collection </a></p>
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
              </div><!-- /.control-box -->

              <!-- <div class="control-box-2">
                  <button class="btn btn-default btn-sm carousel-pause"><span class="glyphicon glyphicon-pause"></span></button>
              </div>--><!-- /.control-box-2 -->

              <ol class="control-box-3 carousel-indicators">
                  <li data-target="#collection-carousel" data-slide-to="0" class="active"></li>
                  <li data-target="#collection-carousel" data-slide-to="1"></li>
                  <li data-target="#collection-carousel" data-slide-to="2"></li>
              </ol><!-- /.control-box-3 -->
      </div>
    </div>
  </div>
</div>

<div>
<?php 
  //$view = views_get_view('all_texts_open');
  //$view->override_path = $_GET['q'];
  //$viewsoutput = $view->preview('panel_pane_1');
  //print $viewsoutput;
  print views_embed_view('all_texts_open','panel_pane_1');
?>
</div>