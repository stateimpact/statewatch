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
    $post = get_default_post_to_edit( $post_type, true );
    $post_ID = $post->ID;
    add_action( 'admin_print_footer_scripts', 'wp_tiny_mce', 25 );
	add_action( 'admin_print_footer_scripts', 'wp_tiny_mce_preload_dialogs', 30 );
	wp_enqueue_script('quicktags');
	
    include(ABSPATH . 'wp-admin/edit-form-advanced.php');
}
?>