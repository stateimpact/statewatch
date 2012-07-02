<?php

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