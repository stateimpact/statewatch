<?php

// site names should just be state names
DEFINE( 'SITE_NAME_PREFIX', 'StateImpact ' );

// includes
require_once( 'includes/users.php' );
require_once( 'includes/sidebars.php' );
require_once( 'includes/stations.php' );
require_once( 'includes/static-widgets.php' );
require_once( 'includes/topics.php' );
require_once( 'includes/sw-widgets.php');

add_action( 'admin_init', 'sw_agg_settings' );
function sw_agg_settings() {
    add_settings_field( 'network_feed_url', 'RSS Feed for Network Widget',
        'sw_network_feed_url_callback', 'agg', 'agg_settings' );
    register_setting( 'agg', 'network_feed_url' );
}

function sw_network_feed_url_callback() {
    $option = get_option( 'network_feed_url' );
    echo "<input type='text' value='$option' name='network_feed_url' />"; 
}


add_action( 'init', 'remove_argo_actions' );
function remove_argo_actions() {    
    remove_action( 'navis_top_strip', 'argo_network_div' );
    remove_action( 'navis_network_icon', 'argo_network_icon' );
    remove_action( 'wp_footer', 'argo_build_network_panel' );
}
?>