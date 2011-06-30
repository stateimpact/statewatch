<?php

// get a post excerpt outside the loop
function sw_get_excerpt_anywhere() {
    global $wp_query;
    $post = $wp_query->get_queried_object();
    $excerpt = $post->post_excerpt;
    if ( !$excerpt ) {
        $words = explode(' ', $post->post_content);
        $excerpt = implode(' ', array_slice($words, 0, 55) );
    }
    
    // just to be sure
    return htmlentities(strip_tags($excerpt), ENT_QUOTES);
}
?>