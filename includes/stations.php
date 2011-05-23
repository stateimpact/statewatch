<?php
add_action( 'init', 'create_station_post_types' );

function create_station_post_types() {
    register_post_type( 'partner_station', 
        array(
            'labels' => array(
                'name' => 'Partner Stations',
                'singular_name' => 'Partner Station',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Station',
                'edit' => 'Edit',
                'edit_item' => 'Edit Station',
                'view' => 'View',
                'view_item' => 'View Station',
                'search_items' => 'Search Stations',
                'not_found' => 'No stations found',
                'not_found_in_trash' => 'No stations found in trash',
            ),
        'description' => 'Partner Stations',
        'exclude_from_search' => true,
        'public' => true,
        'supports' => array('title', 'excerpt', 'thumbnail'),
        'taxonomies' => array(),
        )
    );
};

?>