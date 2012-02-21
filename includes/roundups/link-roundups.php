<?php

class SW_Link_Roundups {
    
    function __construct() {
        add_action('init', array(&$this, 'post_type'));
    }
    
    function post_type() {
        register_post_type( 'roundup', array(
            'labels' => array(
                'name' => 'Link Roundups',
                'singular_name' => 'Link Roundup',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Link Roundup',
                'edit' => 'Edit',
                'edit_item' => 'Edit Link Roundup',
                'view' => 'View',
                'view_item' => 'View Link Roundup',
                'search_items' => 'Search Link Roundups',
                'not_found' => 'No link roundups found',
                'not_found_in_trash' => 'No link roundups found in Trash',
            ),
            'description' => 'Link Roundups',
            'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail' ),
            'public' => true,
            'menu_position' => 6,
            'taxonomies' => array(),
            'has_archive' => true,
        ) );
        
    }
}

new SW_Link_Roundups;


function django_admin_panel( $topic ) {
    $url = get_option( 'django_admin_url' );
    $app = get_option( 'django_app_name' );
    if ( ! url ) {
        return;
    }
    $slug = '';
    $tags = get_the_tags( $topic->ID );
    if ( $tags ) {
        $slug = $tags[0]->slug;
    } 
    else {
        $cats = get_the_category( $topic->ID );
        if ( $cats ) {
            $slug = $cats[0]->slug;
        }
    }

    $inc_url = sprintf( '%s/aggregator/%s/topic/%s?embedded=true', $url, $app, $slug );
    ?>
    
    <div id="latest-links-container"></div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $.get('<?php echo $inc_url; ?>', function(data) {
                jQuery('#latest-links-container').html(data);
                setup_page();
            });
        });
    </script>

    <?php
}

function argo_add_topic_django() {
    add_meta_box( 'django', 'Manage Latest Links', 'django_admin_panel', 'topic', 'normal', 'default' );
}

add_action( 'admin_menu', 'argo_add_topic_django' );

function argo_tweak_post_page() {
    remove_meta_box( 'postcustom', 'post', 'normal' );
    remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
}

add_action( 'admin_menu', 'argo_tweak_post_page' );


/*
 * LINKS IN THIS POST
 */

function argo_post_links_panel( $post ) {
    $links = _argo_extract_links( $post->post_content );

    echo '<ul>';
    foreach ( $links as $link ) {
        echo '<li><a href="' . $link . '">' . $link . '</a></li>';
    }
    echo '</ul>';


}

function _argo_extract_links( $content ) {
    $mcount = preg_match_all( '/<a\s+href="([^"]+)"/', $content, $matches );
    if ( $mcount ) {
        return $matches[1];
    }
    else{
        return array();
    }
}

/*
 * ROUNDUP LINKS
 */
function argo_roundup_links_panel( $post ) {
    $url = get_option( 'django_admin_url' );
    $app = get_option( 'django_app_name' );
    if ( ! url ) {
        return;
    }

    $inc_url = sprintf( '/aggregator/%s/roundup?embedded=true', $app );
?>
    
<div id="roundup-container"></div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#roundup-container').load('<?php echo $inc_url; ?>', function(data) {
            setup_page();
        });
    });
</script>


<?php
    #printf( '<iframe src="%saggregator/%s/roundup" style="width: 100%%; height: 500px;"></iframe>', $url, $app );
}

function argo_add_roundup_links_box() {
    add_meta_box( 'roundup_links', 'Recent Roundup Links', 'argo_roundup_links_panel', 'roundup', 'normal', 'default' );
}

add_action( 'admin_menu', 'argo_add_roundup_links_box' );


?>