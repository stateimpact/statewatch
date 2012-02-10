<?php

// site names should just be state names
DEFINE( 'SITE_NAME_PREFIX', 'StateImpact ' );
DEFINE( 'SW_ROOT', dirname(__FILE__));
DEFINE( 'INCLUDES', SW_ROOT . '/includes/' );

// for template checking in loop
// since constants can't be arrays, this is a space-separated list
DEFINE( 'RICH_CONTENT_TYPES', 'fusiontablesmap');
DEFINE( 'SINGLE_FULL_WIDTH', 'single-full-width.php' );

// includes
require_once( INCLUDES . 'users.php' );
require_once( INCLUDES . 'sidebars.php' );
require_once( INCLUDES . 'stations.php' );
// require_once( INCLUDES . 'static-widgets.php' );
require_once( INCLUDES . 'topics/topics.php' );
require_once( INCLUDES . 'sw-widgets.php');
require_once( INCLUDES . 'settings.php' );
require_once( INCLUDES . 'taxonomy.php' );
require_once( INCLUDES . 'template.php' );
require_once( INCLUDES . 'media.php' );
require_once( INCLUDES . 'admin.php' );
require_once( INCLUDES . 'multimedia.php' );

function sw_loop_post_types() {
    return array('post', 'fusiontablesmap', 'jiffypost', 'roundup');
}

add_filter('pre_get_posts', 'filter_search');
function filter_search($query) {
    if (!is_admin()) {
        if ($query->is_search && !$query->get('suppress_filters')) {
    	    $query->set('post_type', array('post', 'topic', 'fusiontablesmap', 'roundup'));
    	    $query->set('orderby', 'modified');
        };
    }
    return $query;
};

add_action( 'admin_init', 'sw_agg_settings' );
function sw_agg_settings() {
    add_settings_field( 'network_feed_url', 'RSS Feed for Network Widget',
        'sw_network_feed_url_callback', 'agg', 'agg_settings' );
    register_setting( 'agg', 'network_feed_url' );
}

function sw_network_feed_url_callback() {
    $option = get_option( 'network_feed_url' );
    echo "<input type='text' value='$option' name='network_feed_url' />"; 
}

function sw_the_email_link() {
    if ( get_option( 'show_email_link' ) ) {
        echo '<li class="meta-email"><a href="mailto:?subject=';
        the_title();
        echo '&body=';
        the_permalink();
        echo '">Email</a></li>';
    }
}

add_filter('autocreate_taxonomies', 'sw_autocreate_taxonomies');
function sw_autocreate_taxonomies($taxonomies) {
    return array(
        'National' => 'prominence',
        'Slideshow' => 'feature'
    );
}

add_filter('autocreate_menus', 'sw_autocreate_menus');
function sw_autocreate_menus($menus) {
    return array(
        'categories' => 'Categories List',
    );
}

add_action( 'init', 'remove_argo_actions' );
function remove_argo_actions() {    
    remove_action( 'navis_top_strip', 'argo_network_div' );
    remove_action( 'navis_network_icon', 'argo_network_icon' );
    remove_action( 'wp_footer', 'argo_build_network_panel' );
}

add_action( 'widgets_init', 'unload_argo_widgets', 15 );
function unload_argo_widgets() {
    unregister_widget( 'Bio_Widget' );
    unregister_widget( 'Feedback_Widget' );
    unregister_widget( 'Network_Widget' );
    unregister_widget( 'Related_Widget' );
    unregister_widget( 'Support_Widget' );
}

add_filter( 'bloginfo_rss', 'sw_fix_feed_title', 10, 2);
function sw_fix_feed_title($info, $show) {
    if ($show != 'name') {
        // in this case, we only care about the 'name' option
        return $info;
    } else {
        return SITE_NAME_PREFIX . $info;
    }
}

add_filter( 'post_class', 'sw_add_feature_labels', 10, 3);
function sw_add_feature_labels($classes, $class, $post_id) {
    global $wp_query;
    if ($wp_query->current_post == 0) $classes[] = 'first';
    if ($wp_query->current_post == ($wp_query->post_count - 1)) $classes[] = 'last';
    if(navis_post_has_features($post_id)) {
        $classes[] = 'has-features';
    }
    if (sw_is_rich_media()) $classes[] = 'rich-media';
    return $classes;
}


// for some reason this only works here, 
// but should be moved into the SW_Fancybox class at some point
add_filter('image_send_to_editor', 
    'sw_fancybox_image_send_to_editor', 10, 8);
function sw_fancybox_image_send_to_editor($html, $id, $caption, $title, $align, $url, $size, $alt) {
    // we're only interested in images wrapped in links to uploaded images
	if ( $url ) {
	    $uploads_dir = wp_upload_dir();
	    $uploads_dir = $uploads_dir['baseurl'];
	    if ( strpos($url, $uploads_dir) === 0 ) {
    	    // it's an uploaded file, so fancybox it
    	    $html = get_image_tag($id, $alt, $title, $align, $size);
        	$rel = $rel ? ' rel="post-' . esc_attr($id).'"' : '';
    	    $url = esc_attr($url);
    	    $caption = esc_attr($caption);
    	    $html = "<a class='fancybox' href='{$url}' rel='$rel' title='{$caption}'>$html</a>";
	    }
	}
	
    return $html;
}

add_action('rss2_head', 'sw_feed_noindex');
add_action('rss_head', 'sw_feed_noindex');
add_action('atom_head', 'sw_feed_noindex');
function sw_feed_noindex() {
    echo "<robots>noindex, follow</robots>";
}

add_action('admin_print_scripts-post.php', 'sw_add_wordcount_js');
add_action('admin_print_scripts-post-new.php', 'sw_add_wordcount_js');
function sw_add_wordcount_js() {
    $js = get_bloginfo('stylesheet_directory') . "/js/wordcount.js";
    wp_enqueue_script('wordcount', $js, array('jquery'), '0.1');
}

add_filter('fustiontablesmap_taxonomies', 'sw_add_map_taxonomies', 10, 1);
function sw_add_map_taxonomies($taxonomies) {
    array_push($taxonomies, 'feature', 'prominence');
    return $taxonomies;
}

add_filter('navis_related_content_post_types', 'sw_related_content_types');
function sw_related_content_types($post_types) {
    return array('post', 'topic', 'fusiontablesmap');
}

add_action('wp_enqueue_scripts', 'sw_analytics');
function sw_analytics() {
    $src = get_bloginfo('stylesheet_directory') . '/js/analytics.js';
    wp_enqueue_script('sw-analytics', $src, array(), '0.1', true);
}

add_action('wp_head', 'sw_state');
function sw_state() { ?>
    <script>window.SI_STATE_NAME = "<?php bloginfo('name'); ?>"</script>
    <?php
}

?>