<?php
define('MAP_TERM', 'map');
define('DOCUMENTS_TERM', 'documents');
define('TABLES_TERM', 'data');

function sw_add_post_term($post_id, $new_term, $taxonomy) {
    $post_terms = wp_get_object_terms( $post_id, $taxonomy );
    $new_post_terms = array();
    
    $seen = false;
    foreach( $post_terms as $term ) {
        if ( $term->term_id == $new_term->term_id ) {
            $seen = true;
        }
        $new_post_terms[] = $term->slug;
    }
    
    // if we don't already have this term, add it
    if (!$seen) {
        $new_post_terms[] = $new_term->slug;
    }
    
    wp_set_object_terms( $post_id, $new_post_terms, $taxonomy );
}

function sw_remove_post_term($post_id, $out_term, $taxonomy) {
    $post_terms = wp_get_object_terms( $post_id, $taxonomy );
    $new_post_terms = array();
    
    foreach( $post_terms as $term ) {
        if ($term->term_id !== $out_term->term_id) {
            // only add the term if it's not the one we're removing
            $new_post_terms[] = $term->slug;
        }
    }
    
    wp_set_object_terms( $post_id, $new_post_terms, $taxonomy );
}

add_action('save_post', 'sw_feature_maps', 10, 2);
function sw_feature_maps($post_id, $post, $taxonomy = 'feature') {
    if (get_post_type($post_id) !== 'fusiontablesmap') return;
    
    $term = get_term_by( 'slug', MAP_TERM, $taxonomy );
    if (!$term) {
        list($term_id, $tax_id) = wp_insert_term( ucwords(MAP_TERM), $taxonomy );
        $term = get_term($term_id, $taxonomy);
    }
    
    error_log( print_r( $term, true) );
    sw_add_post_term($post_id, $term, $taxonomy);
    
}

add_action('save_post', 'sw_feature_docs', 10, 2);
function sw_feature_docs($post_id, $post, $taxonomy = 'feature') {
    $documents = get_post_meta($post_id, 'documents', true);
    $term = get_term_by( 'slug', DOCUMENTS_TERM, $taxonomy );

    if (!$term) {
        list($term_id, $tax_id) = wp_insert_term( ucwords(DOCUMENTS_TERM), $taxonomy );
        $term = get_term($term_id, $taxonomy);
    }

    if ($documents) {
        sw_add_post_term($post_id, $term, $taxonomy);
    } else {
        sw_remove_post_term($post_id, $term, $taxonomy);
    }
}

add_action('save_post', 'sw_feature_tables', 10, 2);
function sw_feature_tables($post_id, $post, $taxonomy = 'feature') {
    $term = get_term_by( 'slug', TABLES_TERM, $taxonomy );

    if (!$term) {
        list($term_id, $tax_id) = wp_insert_term( ucwords(TABLES_TERM), $taxonomy );
        $term = get_term($term_id, $taxonomy);
    }
    
    if ( strpos($post->post_content, '[spreadsheet') !== false ) {
        sw_add_post_term($post_id, $term, $taxonomy);
    } else {
        sw_remove_post_term($post_id, $term, $taxonomy);
    }
}
?>