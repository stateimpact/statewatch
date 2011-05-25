<?php

add_action( 'init', 'sw_register_sidebars' );
function sw_register_sidebars() {
    
    // sidebar-about.php
    register_sidebar( array(
        'id'          => 'about',
        'name'        => 'About Page Sidebar',
        'description' => 'A special sidebar for the about page'
    ) );
}

?>