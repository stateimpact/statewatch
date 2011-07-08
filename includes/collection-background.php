<?php
<<<<<<< Updated upstream
$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
=======
$topics = get_static_page('topic-index');
$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
$links = sw_get_topic_featured_links( $topic );
$first_link = $links[0];
/* $layout_class = "coll-dl";
if ( $topic->post_content && $first_link['url'] ) {
    $layout_class = "coll-dl";
} elseif ( $topic->post_content ) {
    $layout_class = "coll-d";
} elseif ( $first_link['url'] ) {
    $layout_class = "coll-l";
} else {
	$layout_class = "coll";
} */
>>>>>>> Stashed changes
?>
<?php if ( $topic->post_content ): ?>
	<div class="coll-desc clearfix"> 
		<h6>Background</h6>
	    <?php echo apply_filters( 'the_content', $topic->post_content ); ?>
	</div>
<?php endif; ?>
