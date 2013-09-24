<?php

function sw_remove_some_widgets(){
	// Unregister foundation post sidebar to fix widget title bar markup
	unregister_sidebar( 'post' );
}
// add_action( 'init', 'sw_remove_some_widgets', 11 );

function sw_register_sidebars() {
    // primary
    register_sidebar( array(
        'name' => 'Primary',
        'id' => 'primary-widget-area',
        'description' => 'The primary widget area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    
    // sidebar-about.php
    register_sidebar( array(
        'id'          => 'about',
        'name'        => 'About Page Sidebar',
        'description' => 'A special sidebar for the about page'
    ) );

	// POST PAGE SIDEBAR
    register_sidebar( array(
        'id'           => 'post',
        'name'         => 'Post Page Sidebar',
        'description'  => 'Sidebar in right rail of post pages.',
		'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
	
	// POST BOTTOM WIDGET
	register_sidebar(array(
        'name' => 'Post Bottom',
		 'description' => 'Widget to add uniform content below post',
        'before_widget' => '<div id="post-bottom-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title-hidden" style="display:none;">',
        'after_title' => '</h3>',
	) );
}
add_action( 'init', 'sw_register_sidebars', 12 );


?>