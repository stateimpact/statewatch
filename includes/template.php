<?php

// get a post excerpt outside the loop
add_action('meta_tags', 'sw_meta_description');
function sw_meta_description() {
    global $wp_query;
    
    if ( is_single() ) {
        $post = $wp_query->get_queried_object();
    } elseif ( is_category() or is_tag() ) {
        $cat = $wp_query->get_queried_object();
        $post = argo_get_topic_for( $cat );
    }
    
    $excerpt = $post->post_excerpt;
    if ( !$excerpt ) {
        $words = explode(' ', $post->post_content);
        $excerpt = implode(' ', array_slice($words, 0, 55) );
        $excerpt = strip_shortcodes( $excerpt );
    }
    
    // just to be sure
    $excerpt = esc_attr(strip_tags($excerpt), ENT_QUOTES);
    if (is_single() || is_category() || is_tag() ): ?>
	    <meta name="description" content="<?php echo $excerpt; ?>">
	<?php else: ?>
	    <?php // check for a manual meta description, then fall back to blog tagline
	    $description = get_option('meta_description');
	    if (!$description) $description = get_bloginfo('description'); 
	    $description = esc_attr(strip_tags($description)); ?>
	    <meta name="description" content="<?php echo $description; ?>">
	<?php endif; ?>
	<?php
}

add_filter('single_template', 'sw_full_width_check');
function sw_full_width_check($single_template) {
    global $post;
    $wide_assets = get_post_meta($post->ID, 'wide_assets', true);
    if (!$wide_assets) $wide_assets = array();
    foreach( $wide_assets as $key => $value ) {
        if ($value == true) {
            $single_template = SW_ROOT . '/' . SINGLE_FULL_WIDTH;
        }
    }
    return $single_template;
}

function sw_is_rich_media($post_id = null) {
    if ($post_id) {
        $post = get_post($post_id);
    } else {
        global $post;
    }
    
    $rich_types = explode(' ', RICH_CONTENT_TYPES);
    if ( in_array( get_post_type($post->ID), $rich_types ) ) {
        // check by explicit content types
        return true;
    } elseif (get_post_meta($post->ID, 'custom_post_template', true) == SINGLE_FULL_WIDTH) {
        // fall back to custom post types plugin
        return true;
    } else {
        return false;
    }
    
}
?>