<?php
$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
$links = sw_get_topic_featured_links( $topic );
$first_link = $links[0];
?>
<div id="coll-intro" class="grid_12 coll-dl"> 
<h2><?php echo $topic->post_title; ?></h2>
<?php if ( $topic->post_content ): ?>
<div class="coll-desc clearfix"> 
<h6>Background</h6>
    <?php echo $topic->post_content; ?>    
</div>
<?php endif; ?>
<?php if ( $first_link['url'] ) { ?>
<div class="coll-links">
    <h6>Key Links</h6>
    <ul>
    <?php foreach( $links as $link ): ?>
        <?php if ( $link['url'] ): ?>
            <li><a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a> <span class="key-source">(<?php echo $link['source']; ?>)</span></li>
        <?php endif; ?>
    <?php endforeach; ?>
    </ul>
</div>
<?php }; ?>
</div> <!-- /#coll-intro .grid_12 --> 