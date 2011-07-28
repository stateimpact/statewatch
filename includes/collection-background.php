<?php
$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
?>
<?php if ( $topic->post_content ): ?>
	<div class="coll-desc post clearfix"> 
		<h6>Background</h6>
	    <?php echo apply_filters( 'the_content', $topic->post_content ); ?>
	</div>
<?php endif; ?>
