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
require_once( INCLUDES . 'static-pages.php' );
require_once( INCLUDES . 'topics/topics.php' );
require_once( INCLUDES . 'sw-widgets.php');
require_once( INCLUDES . 'settings.php' );
require_once( INCLUDES . 'taxonomy.php' );
require_once( INCLUDES . 'template.php' );
require_once( INCLUDES . 'media.php' );
require_once( INCLUDES . 'nav.php');
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

//add_filter('autocreate_menus', 'sw_autocreate_menus');
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

// argo-foundation functions.php
if ( ! function_exists( 'argo_the_page_number' ) ) :
/**
 * Prints the page number currently being browsed, with a vertical bar before 
 * it. 
 */
function argo_the_page_number() {
	global $paged; // Contains page number.
	if ( $paged >= 2 )
		echo ' | ' . 'Page ' . $paged;
}
endif;

function argo_get_related_topics_for_category( $obj ) { 
    $MAX_RELATED_TOPICS = 5;

    $cat_id = $obj->cat_ID;
    if ( $obj->post_type ) {
        if ( $obj->post_type == 'nav_menu_item' ) {
            $cat_id = $obj->object_id;
        }
    }

    $out = "<ul>";
     
    // spit out the subcategories
    $cats = _subcategories_for_category( $cat_id );

    foreach ( $cats as $c ) {
        $out .= sprintf( '<li><a href="%s">%s</a></li>',
            get_category_link( $c->term_id ), $c->name
        );
    }

    if ( count( $cats ) < $MAX_RELATED_TOPICS ) {
        $tags = _tags_associated_with_category( $cat_id, 
            $MAX_RELATED_TOPICS - count( $cats ) );

        foreach ( $tags as $t ) {
            $out .= sprintf( '<li><a href="%s">%s</a></li>',
                get_tag_link( $t->term_id ), $t->name
            );
        }
    }

    $out .= "</ul>";
    return $out;
}


function _tags_associated_with_category( $cat_id, $max = 5 ) {
    $query = new WP_Query( array( 
        'posts_per_page' => -1,
        'cat' => $cat_id,
    ) );

    // Get a list of the tags used in posts in this category.
    $tags = array();
    $tag_objs = array();
    foreach ( $query->posts as $post ) {
        $ptags = get_the_tags( $post->ID );
        if ( $ptags ) {
            foreach ( $ptags as $tag ) {
                $tags[ $tag->term_id ]++;
                $tag_objs[ $tag->term_id ] = $tag;
            }
        }
    }

    // Sort the most popular and get the $max results, or all results
    // if max is -1
    arsort( $tags, SORT_NUMERIC );
    if ( $max == -1 ) {
        $tag_keys = array_keys( $tags );
    }
    else {
        $tag_keys = array_splice( array_keys( $tags ), 0, $max );
    }

    // Create an array of the selected tag objects
    $return_tags = array();
    foreach ( $tag_keys as $tk ) {
        array_push( $return_tags, $tag_objs[ $tk ] );
    }

    return $return_tags;
}


function _subcategories_for_category( $cat_id ) {
    // XXX: could also use get_term_children().  not sure which is better.
    $cats = get_categories( array( 
        'child_of' => $cat_id, 
    ) );

    return $cats;
}

/**
 * Builds links to the latest posts for a given category.
 *
 * @todo 3.1 replace caller_get_posts with ignore_sticky_posts
 *
 * @param   object  $cat    Term object
 * @return  string
 */
function argo_get_latest_posts_for_category( $cat ) {
    $query = new WP_Query( array( 
        'showposts' => 4,
        'orderby' => 'date',
        'order' => 'DESC',
        'cat' => $cat->object_id,
        'caller_get_posts' => 1,
    ) );

    $output = '';
    foreach ( $query->posts as $post ) {
        $output .= '<h4><a href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</a></h4>';
    }

    return $output;
}

/**
 * Same as argo_get_post_thumbnail_src(), but for use inside The Loop.
 */
function argo_get_the_post_thumbnail_src( $size = 'npr_thumb' ) {
    global $post;
    return argo_get_post_thumbnail_src( $post, $size );
}

/*
 * XXX: this may not be necessary the_post_thumbnail takes sizes. -- ML
 */
function argo_get_post_thumbnail_src( $post, $size = 'npr_thumb' ) {
    if ( has_post_thumbnail( $post->ID ) ) {
        $thumb = get_post_thumbnail_id( $post->ID );
        $image = wp_get_attachment_image_src( $thumb, $size );
        return $image[ 0 ]; // src
    } 
}

/* Tracking posts tagged Featured or National in the prominence taxonomy with Google Analytics */
function argo_prominence_tracker() {
    global $post;
    if (is_object_in_term($post->ID,'prominence',array('featured','national')) ) {
        echo "<script>_gaq.push(['_setCustomVar',1,'prominence','Featured and/or National',3]);</script>";
    }
}

if ( ! function_exists( 'argo_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post date/time
 */
function argo_posted_on() {
    printf( '<span class="entry-date">%1$s | %2$s</span>',
        // XXX: set this as the default time format instead of overriding here
        get_the_date(), esc_attr( get_the_time( 'g:i A' ) ) 
    );
}
endif;

// XXX: better way to do this
function _filter_post_types( $t ) {
    $filter_out = array( 'attachment', 'page', 'topic' );
    return ! in_array( $t, $filter_out );
}

function _map_post_types( $t ) {
    return 'post_type[]=' . $t; 
}

function argo_post_types_qs() {
    global $query_string;
    $all_post_types = get_post_types( array( 'public' => true ) );

    // XXX: there should be a better way to include our post types
    $post_types = array_filter( $all_post_types, '_filter_post_types' );
    $post_types = array_map( '_map_post_types', $post_types );
    array_unshift( $post_types, $query_string );
    $qs = join( '&', $post_types );
    return $qs;
}


/**
* A pagination function
* @param integer $range: The range of the slider, works best with even numbers
* Used WP functions:
* get_pagenum_link($i) - creates the link, e.g. http://site.com/page/4
* previous_posts_link(' < '); - returns the Previous page link
* next_posts_link(' > '); - returns the Next page link
*/
function argo_pagination($range = 4){
  // $paged - number of the current page
  global $paged, $wp_query;
  // How much pages do we have?
  if ( !$max_page ) {
    $max_page = $wp_query->max_num_pages;
  }
  // We need the pagination only if there are more than 1 page
  if($max_page > 1){
    if(!$paged){
      $paged = 1;
    }
    
    // To the previous page
    previous_posts_link(' &larr; Newer Posts');
    // We need the sliding effect only if there are more pages than is the sliding range
    if($max_page > $range){
      // When closer to the beginning
      if($paged < $range){
        for($i = 1; $i <= ($range + 1); $i++){
          echo "<a href='" . get_pagenum_link($i) ."'";
          if($i==$paged) echo "class='current'";
          echo ">$i</a>";
        }
      }
      // When closer to the end
      elseif($paged >= ($max_page - ceil(($range/2)))){
        for($i = $max_page - $range; $i <= $max_page; $i++){
          echo "<a href='" . get_pagenum_link($i) ."'";
          if($i==$paged) echo "class='current'";
          echo ">$i</a>";
        }
      }
      // Somewhere in the middle
      elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
        for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){
          echo "<a href='" . get_pagenum_link($i) ."'";
          if($i==$paged) echo "class='current'";
          echo ">$i</a>";
        }
      }
    }
    // Less pages than the range, no sliding effect needed
    else{
      for($i = 1; $i <= $max_page; $i++){
        echo "<a href='" . get_pagenum_link($i) ."'";
        if($i==$paged) echo "class='current'";
        echo ">$i</a>";
      }
    }
    // Next page
    next_posts_link(' Older Posts &rarr; ');
    // On the last page, don't put the Last page link
    
  }
}

/**
 * argo_get_twitter_screen_name(): provide the actual screen name or the blog's 
 * name.
 */
function argo_get_twitter_screen_name() {
    // XXX: change twitter_link property to only contain screename.
    $turl = get_option( 'twitter_link' );
    if ( $turl ) {
        $screen_name = preg_replace( '/https?:\/\/twitter.com\/\#?\!?\/?/', '', $turl );
        return '@' . $screen_name;
    }
    else {
        return get_bloginfo( 'name' );
    }
}

function argo_get_sanitized_title( $max_title_length = 140 ) {
    $title = get_the_title();

    if ( strlen( $title ) > $max_title_length ) {
        $title = substr( $title, 0, $max_title_length - 3 ) . '...';
    }

    return rawurlencode( $title );
}

function argo_get_twitter_title() {
    $screen_name = argo_get_twitter_screen_name();
    
    // 22 = length of short url
    // 7 = tweet prefix and suffix
    $max_title_length = 140 - 22 - 7 - strlen( $screen_name );

    $title = argo_get_sanitized_title( $max_title_length );
    $tweet = sprintf( 'Via %s: %s |', $screen_name, $title );
    return $tweet;
}

/**
 * Determines whether a post has a "main" item from the feature custom 
 * taxonomy. Expects to be called from within The Loop.
 *
 * @uses global $post
 * @return bool
 */
function navis_post_has_features() {
    global $post;

    $features = get_the_terms( $post->ID, 'feature' );

    return ( $features ) ? true : false;
}

/**
 * Echoes a post's manual excerpt so long as it's less than the given word 
 * limit.
 *
 * @param $word_limit maximum number of words to allow.
 * @uses global $post
 */
function navis_the_raw_excerpt( $word_limit = 35 ) {
    global $post;

    $raw_excerpt = $post->post_excerpt;
    if ( ! $raw_excerpt )
        return;

    if ( count( navis_split_words( $raw_excerpt ) ) > $word_limit )
        return;

    echo $post->post_excerpt;
}

function navis_split_words( $text, $split_limit = -1 ) {
    // XXX: deal with the way argo_get_excerpt uses this limit to 
    // determine whether to cut off remaining text.
    if ( $split_limit > -1 )
        $split_limit += 1;
    
    $words = preg_split( "/[\n\r\t ]+/", $text, $split_limit, 
                         PREG_SPLIT_NO_EMPTY );

    return $words;
}

function argo_term_to_label( $term ) {
    return sprintf( '<li> <a href="%1$s">%2$s</a></li>',
                    get_term_link( $term, $term->taxonomy ), 
                    strtoupper( $term->name ) );
}

if ( ! function_exists( 'argo_the_post_labels' ) ) :
function argo_the_post_labels( $post_id ) {
    $post_terms = argo_custom_taxonomy_terms( $post_id );
    $all_labels = $post_terms;
    foreach ( $all_labels as $term ) {
        // XXX: temporary hack
        if ( strtolower( $term->name ) == 'short post' ) {
            continue;
        }
        echo argo_term_to_label( $term );
    }
}
endif;

if ( ! function_exists( 'argo_custom_taxonomy_terms' ) ) :
function argo_custom_taxonomy_terms( $post_id ) {
    // XXX: need better way of introspecting custom taxonomies.
    global $CUSTOM_TAXONOMIES;
    $post_terms = array();
    foreach ( (array)$CUSTOM_TAXONOMIES as $tax ) {
        if ( taxonomy_exists( $tax ) ) {
            $terms = get_the_terms( $post_id, $tax );
            if ( $terms ) {
                $post_terms = array_merge( $post_terms, $terms );
            }
        }
    }

    return $post_terms;
}
endif;

/**
 * Builds the proper searchform action URL. This works around a condition with
 * WordPress MultiSite that requires this URL to have a trailing slash.
 *
 */
function navis_the_searchform_url() {
    $url = get_bloginfo( 'url', 'display' );
    echo ( $url ) ? trailingslashit( $url ) : $url;
}


?>