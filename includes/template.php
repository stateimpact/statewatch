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
	    $description = get_option('meta_description', get_bloginfo('description')); 
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
            $single_template = SW_ROOT . '/single-full-width.php';
        }
    }
    return $single_template;
}
?>