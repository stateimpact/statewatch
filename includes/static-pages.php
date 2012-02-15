<?php
include_once(ABSPATH . 'wp-admin/includes/theme.php');

function argo_create_static_pages() {
    // Automatically create the topic index page.
    $query = new WP_Query( array( 'post_type' => 'page',
                                  'meta_key' => 'static_page',
                                  'meta_value' => 'topic-index' ) );
    
    if ( count( $query->posts ) < 1 ) {
        $ti_page = array();
        $ti_page['post_type'] = 'page';
        $ti_page['post_title'] = 'Topic Index';
        $ti_page['post_name'] = 'topic-index';
        $ti_page['post_content'] = '';
        // XXX: ideally, use update_post_meta for _wp_page_template
        $ti_page['page_template'] = 'topic-index.php';
        $ti_page['post_status'] = 'publish';
        $ti_page['post_author'] = 1;

        $page_id = wp_insert_post( $ti_page );
        //update_post_meta( $page_id, '_wp_page_template', 'Topic index' );
        update_post_meta( $page_id, 'static_page', 'topic-index' );
    }

    // Give the about page a static_page custom field value as well.
    $aquery = new WP_Query( array( 'post_type' => 'page',
                                   'pagename'  => 'about' ) );
    $apage = $aquery->posts[0];
    update_post_meta( $apage->ID, 'static_page', 'about' );
}
add_action( 'init', 'argo_create_static_pages' );

function get_static_page( $page_name ) {
    $query = new WP_Query( array( 'post_type' => 'page',
                                  'meta_key' => 'static_page',
                                  'meta_value' => $page_name ) );
    if ( count( $query->posts ) > 0 ) {
        return $query->posts[0];
    }
    else {
        return false;
    }
}

function get_static_page_link( $page_name ) {
   $page = get_static_page( $page_name );
   return ( $page ) ? get_page_link( $page->ID ) : '#';
}

function navis_get_about_text() {
    $page = get_static_page('about');
    if ($page) {
        return $page->post_content;
    } else {
        return '';
    }
}

?>
