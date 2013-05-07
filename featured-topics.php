<?php $topics = get_static_page('topic-index'); ?>
<div class="featured-topics grid_12">

	<h2>Essential Reading</h2>
	<?php wp_nav_menu( array( 
	    'theme_location' => 'featured-topics',
	    'menu'           => 'featured-topics',
	    'container'      => false, // don't wrap in a div
	    'items_wrap'     => '%3$s', // no ul wrapping 
	    'depth'          => -1, // flatten items
	    'walker'         => new SW_Featured_Topics_Walker
	) ); ?>
    <div class="alltopics"><a href="<?php echo get_permalink( $topics->ID ); ?>">View All Topics &raquo;</a></div>
</div><!-- .grid_12 -->