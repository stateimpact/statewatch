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
        $words = strip_shortcodes( $post->post_content );
        $words = explode(' ', $words);
        $excerpt = implode(' ', array_slice($words, 0, 55) );
    }
    
    // just to be sure
    $excerpt = esc_attr(strip_tags($excerpt), ENT_QUOTES);
    if (is_single() ): ?>
	    <meta name="description" content="<?php echo $excerpt; ?>">
        <meta property="og:title" content="<?php echo esc_attr(get_the_title()); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?php the_permalink(); ?>" />
    <?php if (wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) ); ?>
        <meta property="og:image" content="<?php echo wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) ); ?>" />
    <?php endif; ?>
        <meta property="og:site_name" content="StateImpact <?php echo get_option('blogname'); ?>" />
        <meta property="fb:admins" content="10217706" />
        <meta property="og:description" content="<?php echo $excerpt; ?>">
    <?php elseif ( is_category() || is_tag() ): 
            $cat = $wp_query->get_queried_object();
            $topic = argo_get_topic_for( $cat );    
    ?>
        <meta name="description" content="<?php echo $excerpt; ?>">
        <meta property="og:title" content="<?php echo esc_attr( $topic->post_title ); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?php echo esc_url($topic->guid); ?>" />
        <meta property="og:image" content="<?php echo wp_get_attachment_thumb_url( get_post_thumbnail_id( $topic->ID ) ); ?>" />
        <meta property="og:site_name" content="StateImpact <?php echo get_option('blogname'); ?>" />
        <meta property="fb:admins" content="10217706" />
        <meta property="og:description" content="<?php echo $excerpt; ?>">
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

add_action('wp_enqueue_scripts', 'sw_enqueue_fb');
function sw_enqueue_fb() {
    $fb = 'http://connect.facebook.net/en_US/all.js#xfbml=1';
    wp_enqueue_script('facebook', $fb);
}

?>