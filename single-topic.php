<?php 
if ( have_posts() ) while ( have_posts() ): the_post();
    $taxonomies = array('post_tag', 'category');
    $terms = wp_get_object_terms($post->ID, $taxonomies);
    if (is_array($terms)) {
        $url = get_term_link($terms[0]);
        // error_log('Redirecting to ' . $url);
        wp_redirect($url);
        exit;
    }
endwhile;
?>