<?php
$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
$links = sw_get_topic_featured_links( $topic );
$first_link = $links[0];
?>
<?php if ( $first_link['url'] ) { ?>
	<div class="topic-links">
	    <h2 class="section-hed">Key Links</h2>
	    <ul>
	    <?php foreach( $links as $link ): ?>
	        <?php if ( $link['url'] ): ?>
	            <li><a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a> <span class="key-source"><?php echo $link['source']; ?></span></li>
	        <?php endif; ?>
	    <?php endforeach; ?>
	    </ul>
	</div>
<?php }; ?>