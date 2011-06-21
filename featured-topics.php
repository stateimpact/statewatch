<?php $topics = get_static_page('topic-index'); ?>
<div class="featured-topics grid_12">

	<h2>Essential Reading</h2>
	<?php wp_nav_menu( array( 
	    'theme_location' => 'featured-topics',
	    'menu'           => 'featured-topics',
	    'container'      => false,
	    'walker'         => new SW_Topics_Walker
	) ); ?>
    <div class="alltopics"><a href="<? echo get_permalink( $topics->ID ); ?>">View all topics &raquo;</a></div>
</div><!-- .grid_12 -->