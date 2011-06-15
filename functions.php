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

define( 'LARGE_WIDTH', 460 );
define( 'MEDIUM_WIDTH', 230 );

add_action( 'init', 'remove_argo_actions' );
function remove_argo_actions() {
    remove_action( 'wp_footer', 'argo_build_network_panel' );
}
?>