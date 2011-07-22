<?php

function remove_some_widgets(){
	// Unregister foundation post sidebar to fix widget title bar markup
	unregister_sidebar( 'post' );
}
add_action( 'init', 'remove_some_widgets', 11 );



function sw_register_sidebars() {
    
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
}
add_action( 'init', 'sw_register_sidebars', 12 );


?>