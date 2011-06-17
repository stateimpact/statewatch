<?php if ( have_posts() ) while ( have_posts() ): the_post();
    // var_dump($post);
    $url = sw_get_topic_permalink($post);
    if ($url) { 
        wp_redirect( $url ); exit; 
    }

    // we've got tags
    $tags = get_the_tags();
    foreach($tags as $i => $tag) {
        $url = get_tag_link($tag->term_id);
        if ($url) wp_redirect( $url ); exit;
    }
    endwhile;
?>