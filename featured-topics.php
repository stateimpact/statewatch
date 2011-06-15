<div class="featured-topics grid_12">

	<h2>Essential Reading</h2>
	<?php wp_nav_menu( array( 
	    'theme_location' => 'featured-topics',
	    'menu'           => 'featured-topics',
	    'container'      => false,
	    'walker'         => new SW_Topics_Walker
	) ); ?>
    
</div><!-- .grid_12 -->