<?php

// get a post excerpt outside the loop
add_action('meta_tags', 'sw_meta_description');
function sw_meta_description() {
    global $wp_query;
    $post = $wp_query->get_queried_object();
    $excerpt = $post->post_excerpt;
    if ( !$excerpt ) {
        $words = explode(' ', $post->post_content);
        $excerpt = implode(' ', array_slice($words, 0, 55) );
        $excerpt = strip_shortcodes( $excerpt );
    }
    
    // just to be sure
    $excerpt = htmlentities(strip_tags($excerpt), ENT_QUOTES);
    if (is_single()): ?>
	    <meta name="description" content="<?php echo $excerpt; ?>">
	<?php else: ?>
	    <meta name="description" content="<?php bloginfo('description'); ?>">
	<?php endif; ?>
	<?php
}
?>