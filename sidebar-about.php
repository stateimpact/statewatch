<?php
/**
 * about page sidebar
 */
?>

<div id="category-sidebar" class="widget-area" role="complementary">
<ul class="widget-list">

<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( ! dynamic_sidebar( 'about' ) ) : ?>
	
			<!-- show if sidebar is empty -->

<?php endif; // end primary widget area ?>
			</ul>
		</div><!-- #primary .widget-area -->
