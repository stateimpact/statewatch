<?php

class Featured_Posts_Widget extends WP_Widget {
    
    function Featured_Posts_Widget() {
        $widget_options = array(
            'classname' => 'sw-featured-posts',
            'description' => 'Show a custom menu for Featured Posts'
        );
        $this->WP_Widget( 'featured-posts-widget', 'Featured Posts', $widget_options);
    }
    
    function form($instance) {
        if (isset($instance['title'])) {
            $title = esc_attr( $instance[ 'title' ] );
        } else {
            $title = "Featured Posts";
        }
        ?>
		<p>
    		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
    		<input class="widefat" 
    		       id="<?php echo $this->get_field_id('title'); ?>" 
    		       name="<?php echo $this->get_field_name('title'); ?>" 
    		       type="text" value="<?php echo $title; ?>" />
		</p>
		<?php 
    }
    
    function widget($args, $instance) {
        extract($args);
        echo $before_widget;
        if ( !empty( $instance['title'] ) ): ?>
        <h3><?php echo $instance['title']; ?></h3>
        <?php endif;
        wp_nav_menu(array(
            'theme_location' => 'featured-posts',
            'menu' => 'featured-posts',
            'depth' => 1,
            'walker' => new Featured_Posts_Walker
        )); 
        echo $after_widget;
    }
    
}

class Featured_Posts_Walker extends Walker_Nav_Menu {
    
    function start_el( &$output, $item, $depth, $args ) {
        $output .= '<li class="featured-post clearfix">';
        if (has_post_thumbnail($item->object_id)) {
            $thumb = get_the_post_thumbnail($item->object_id, array(60,60), array(
                'class' => 'alignright'
            ));
            $output .= '<a href="' . $item->url . '">' . $thumb . '</a>';
        }
        $output .= '<a href="' . $item->url . '">' . $item->title . '</a>';
    }
    
    function end_el( &$output, $item, $depth ) {
        $output .= "</li>\n";
    }
}


class SW_Featured_Posts {
    
    function __construct() {
        // add menus
        add_action('after_setup_theme', array(&$this, 'featured_posts_menu'));
        
        // add image size
        add_action('init', array(&$this, 'image_size'));
    }
    
    function featured_posts_menu() {
        // in case we want to create more later
        $menus = array(
            'featured-posts' => 'Featured Posts'
        );
        register_nav_menus($menus);

        /*
         * Try to automatically link menus to each of the locations.
         * Shamelessly copied from Argo Foundation
         */
        foreach ( $menus as $location => $label ) {
            // if a location isn't wired up...
            if ( ! has_nav_menu( $location ) ) {

                // get or create the nav menu
                $nav_menu = wp_get_nav_menu_object( $label );
                if ( ! $nav_menu ) {
                    $new_menu_id = wp_create_nav_menu( $label );
                    $nav_menu = wp_get_nav_menu_object( $new_menu_id );
                }

                // wire it up to the location
                $locations = get_theme_mod( 'nav_menu_locations' );
                $locations[ $location ] = $nav_menu->term_id;
                set_theme_mod( 'nav_menu_locations', $locations );
            } 
        }

    }
    
    function image_size() {
        add_image_size('featured-thumb', 60, 60, true);
    }
}

new SW_Featured_Posts;

?>