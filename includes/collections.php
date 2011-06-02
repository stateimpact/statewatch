<?php
add_action( 'init', 'sw_create_collection_post_type');
function sw_create_collection_post_type() {
    register_post_type( 'collection', array(
        'labels' => array(
            'name' => 'Collections',
            'singular_name' => 'Collections',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Collection',
            'edit' => 'Edit',
            'edit_item' => 'Edit Collection',
            'view' => 'View',
            'view_item' => 'View Collection',
            'search_items' => 'Search Collections',
            'not_found' => 'No collections found',
            'not_found_in_trash' => 'No collections found in trash',   
        ),
        'description' => 'Collections',
        'exclude_from_search' => true,
        'public' => false,
        'show_ui' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
    ));
}

$taxonomies = array( 'post_tag', 'category' );
foreach ( $taxonomies as $taxonomy ) {
    add_action( $taxonomy . '_edit_form', 'sw_explainer_form' );
};

function sw_explainer_form( $taxonomy ) {
    $post_type = "collection";
    include(ABSPATH . 'wp-admin/edit-form-advanced.php');
}
?>