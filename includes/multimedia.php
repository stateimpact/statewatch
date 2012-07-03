<?php

/**
* Multimedia Widget displays most recent multimedia entries
*/
class SI_Multimedia_Widget extends WP_Widget {
    
    function __construct() {
        $options = array(
            'classname' => 'sw-multimedia',
            'description' => 'Links to recent multimedia'
        );
        parent::__construct('multimedia-widget', 'Multimedia', $options);
    }

    function form($instance) {

        if (isset($instance['title'])) {
            $title = esc_attr(strip_tags($instance['title']));
        } else {
            $title = "Multimedia";
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
        // render this thing
        extract($args);
        $multimedia = new WP_Query(array(
            'post_type' => 'multimedia',
            'posts_per_page' => 5,
            'suppress_filters' => true
        ));

        echo $before_widget;
        
        if ( !empty( $instance['title'] ) ): ?>
        <h3><?php echo $instance['title']; ?></h3>
        <?php endif; ?>
        
        <?php while ($multimedia->have_posts()): $multimedia->the_post(); ?>
            <?php $content_types = wp_get_object_terms($post->ID, 'feature'); ?>
            <?php if (has_post_thumbnail()): ?>
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('multimedia-thumb'); ?></a>
            <?php endif; ?>
            <h4 class="headline">
                <a href="<?php the_permalink(); ?>">
                <?php if ($content_types): ?>
                    <strong><?php echo $content_types[0]->name; ?>: </strong>
                <?php endif; ?>
                    <?php the_title(); ?>
                </a>
            </h4>
        <?php endwhile;
        echo $after_widget;
    }
}

register_widget('SI_Multimedia_Widget');


class SI_Multimedia {
    
    function __construct() {
        
        // create a post type
        add_action('init', array(&$this, 'add_post_type'), 15);
        
        // metaboxes
        add_action( 'add_meta_boxes', array(&$this, 'add_metaboxes'));
        
        // save it all
        add_action( 'save_post', array(&$this, 'save'));
        
        add_action( 'init', array(&$this, 'image_size'));

        add_filter( 'post_type_link', array(&$this, 'permalink'), 9, 4);
    }
    
    function add_post_type() {
        register_post_type('multimedia', array(
            'labels' => array(
                'name' => 'Multimedia',
                'singular_name' => 'Multimedia',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Multimedia',
                'edit' => 'Edit',
                'edit_item' => 'Edit Multimedia',
                'view' => 'View',
                'view_item' => 'View Multimedia',
                'search_items' => 'Search Multimedia',
                'not_found' => 'No multimedia found',
                'not_found_in_trash' => 'No multimedia found in trash',
            ),
            'description' => 'Multimedia',
            'exclude_from_search' => true,
            'public' => true,
            'show_ui' => true,
            'supports' => array('title', 'excerpt', 'thumbnail'),
            'taxonomies' => array('category', 'post_tag', 'feature'),
        ));
    }
    
    function image_size() {
        add_image_size( 'multimedia-thumb', 300, 100, true ); 
        add_image_size( 'thumb-100', 100, 100, true ); 
    }

    
    function add_metaboxes() {
        add_meta_box( 'multimedia-url', 'URL', array(&$this, 'render_metabox'),
                      'multimedia', 'normal', 'high');
    }
    
    function render_metabox($post) { 
        $url = get_post_meta($post->ID, 'multimedia_url', true);
        ?>
        <p>
            <label for="url">URL</label>
            <input type="text" value="<?php echo $url; ?>" name="mm-url" placeholder="http://www.example.com">
            <span class="description">Where does this thing live on the web?</span>
        </p>
        <?php
    }
    
    function save($post_id) {
        if ((get_post_type($post_id) === 'multimedia') && isset($_POST['mm-url'])) {
            update_post_meta($post_id, 'multimedia_url', $_POST['mm-url']);
        }
    }

    function permalink($post_link, $post, $leavename, $sample) {
        if ($post->post_type === "multimedia") {
            return get_post_meta($post->ID, 'multimedia_url', true);
        }
        return $post_link;
    }
}

$sw_multimedia = new SI_Multimedia;

?>