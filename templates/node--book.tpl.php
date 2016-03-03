<?php
$book_title = $variables['book']['link_title'];
$bid = $variables['book']['bid'];
?>
<div id="shanti-texts-container">
    <div id="shanti-texts-body" class="col-md-7">
        <?php print views_embed_view('single_text_body','panel_pane_default',$variables['book']['bid']); ?>
    </div>
    <div id="shanti-texts-sidebar" role="tabpanel" class="col-md-5">
        <ul id="shanti-texts-sidebar-tabs" class="nav nav-tabs nav-justified" role="tablist">
            <li class="first" role="presentation">
                <a aria-expanded="true" data-toggle="tab" href="#shanti-texts-toc" role="tab">Contents</a>
            </li>
            <li class="" role="presentation">
                <a data-toggle="tab" href="#shanti-texts-meta" role="tab">Description</a>
            </li>
            <li class="" role="presentation">
                <a data-toggle="tab" href="#shanti-texts-links" role="tab">Views</a>
            </li>
        </ul>  
        <div class="tab-content">
            <div id="shanti-texts-toc" class="tab-pane" role="tabpanel">
                <div class="shanti-texts-record-title"><a href="#shanti-texts-<?php print $bid; ?>"><?php print $book_title; ?></a></div>
                <?php print views_embed_view('single_text_toc', 'panel_pane_default',$variables['book']['bid']); ?>
            </div>
            <div id="shanti-texts-meta" class="tab-pane" role="tabpanel">
                <div class="shanti-texts-record-title"><?php print $book_title; ?></div>
                <?php print views_embed_view('single_text_meta', 'panel_pane_default',$variables['book']['bid']); ?>
            </div>
            <div id="shanti-texts-links" class="links tab-pane" role="tabpanel">
                <div class="shanti-texts-record-title"><?php print $book_title; ?></div>
                <?php print views_embed_view('single_text_views', 'panel_pane_default',$variables['book']['bid']); ?>
            </div>
        </div>
    </div>
</div>