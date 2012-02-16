<?php
/**
 * The Sidebar containing the primary widget area.
 */
?>
<div id="primary" class="widget-area" role="complementary">
    <ul class="widget-list">

<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
        dynamic_sidebar( 'primary-widget-area' );
	//if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : 
	// endif; // end primary widget area ?>
    </ul>
</div><!-- #primary .widget-area -->
