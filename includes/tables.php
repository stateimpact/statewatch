<?php
// tablesorter

add_action('save_post', 'sw_table_detector');
function sw_table_detector($post_id) {
    $post = get_post($post_id);
    $tables = get_post_meta($post_id, 'tables', true);
    
    if (preg_match_all('/'.get_shortcode_regex().'/', $post->post_content, $matches)) {
        $tags = $matches[2];
        $args = $matches[3];

        foreach($tags as $i => $tag) {
            if ($tag == "gdoc") {
                $atts = shortcode_parse_atts($args[$i]);
                $tables[$atts['key']] = $atts;
            }
        }
        
        update_post_meta($post_id, 'tables', $tables);
    }
}

add_action('wp_enqueue_scripts', 'sw_tablesorter');
function sw_tablesorter() {
    global $post;
    
    if (is_single()) {
        $tables = get_post_meta($post->ID, 'tables', true);
        if ($tables) {
            $src = get_bloginfo('stylesheet_directory') . '/js/jquery.tablesorter.min.js';
            wp_enqueue_script('tablesorter', $src, array('jquery'));            
        }
    }
}

add_action('wp_head', 'sw_fancybox_config');
function sw_fancybox_config() { 
    global $post;
    if (is_single() && get_post_meta($post->ID, 'tables', true)): ?>
        <script>
        jQuery(function($) {
            $('.post table').tablesorter();
        });
        </script>
    <?php endif;
}

?>