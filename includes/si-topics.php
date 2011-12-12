<?php

class SI_Topics {
    
    public $POST_TYPE = "topic";
    
    function __construct() {
        // unhook argo events
        add_action('init', array($this, 'unhook_argo_events'));
        
        // check for post type, create if necessary
        // push this down the stack to account for the parent theme
        add_action('init', array($this, 'create_post_type'), 15);
        
        // create topic on created_term
        add_action('created_term', array($this, 'create_topic'), 10, 3);
        
        // update topic on edited_term
        add_action('edited_term', array($this, 'update_topic'), 10, 3);
        
        // metaboxes
        add_action('add_meta_boxes', array($this, 'add_metaboxes'));
        
        // save links on save_post, fixing old data model if needed
        add_action('save_post', array($this, 'save_post'));
        
        // include assets
        add_action( 'admin_print_scripts-topic.php', 
            array( &$this, 'register_admin_scripts' )
        );
        add_action( 'admin_print_scripts-topic-new.php', 
            array( &$this, 'register_admin_scripts' )
        );
        
    }
    
    function unhook_argo_events() {
        $actions = array(
            'created_term' => 'argo_create_topic_page',
            'edited_term' => 'argo_create_topic_page',
            'save_post' => 'argo_update_topic_taxonomy',
            'add_meta_boxes_topic' => 'argo_tweak_topic_meta_boxes',
            'admin_menu' => 'argo_trim_topics_admin_menu',
        );
        foreach($actions as $action => $callback) {
            if ( has_action($action, $callback) ) {
                remove_action($action, $callback);
            }
        }
    }
    
    function add_metaboxes() {
        add_meta_box('featured-posts', 'Featured Posts', array($this, 'featured_posts_form'),
                    'topic', 'normal', 'high');
        
        add_meta_box( 'featured-links', 'Featured Links', array($this, 'featured_links_form'),
                      'topic', 'normal', 'high');
    }
    
    function featured_posts_form($post) {
        
    }
    
    function featured_links_form($post) { ?>
        <table class="form-table">
            <tr>
                <td></td>
                <th>Link Title</th>
                <th>URL</th>
                <th>Source</th>
            </tr>

            <?php // this feels dirty ?>
            <?php foreach( range(0, 4) as $i ): ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <?php $fields = array( 'title', 'url', 'source' ); ?>
                <?php foreach( $fields as $field ): ?>
                <td>
                    <?php $name = "link_" . $i . "_" . $field; ?>
                    <?php $value = get_post_meta( $post->ID, $name, true ); ?>
                    <input type="text" id="<?php echo $name; ?>" 
                           name="<?php echo $name; ?>" 
                           value="<?php echo $value; ?>" />
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php
    }
    
    function create_post_type() {
        if ( post_type_exists( $this->POST_TYPE ) ) return;
        
        register_post_type( 'topic', array(                                         
            'labels' => array(                                                      
                'name' => 'Topics',                                                 
                'singular_name' => 'Topic',                                         
                'add_new' => '',                                             
                'add_new_item' => 'Add New Topic',                                  
                'edit' => 'Edit',                                                   
                'edit_item' => 'Edit Topic',                                        
                'view' => 'View',                                                   
                'view_item' => 'View Topic',                                        
                'search_items' => 'Search Topics',
                'not_found' => 'No topics found',
                'not_found_in_trash' => 'No topics found in Trash',
            ),                                                                      
            'description' => 'Topic pages',
            'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
            'public' => true,
            'menu_position' => 8,
            // 'taxonomies' => array( 'feature', 'post_tag', 'category' ),
        ) );
    }
    
    function create_topic($term_id, $tt_id, $taxonomy) {
        $term = get_term( $term_id, $taxonomy );
        error_log('Creating topic from term: ' . $term->name);
        
        $topics = new WP_Query(array(
            'post_name' => $term->slug,
            'post_type' => $this->POST_TYPE
        ));
        if ($topics->post_count > 0) {
            // we already have this topic, bail out
            return;
        }
        
        // Gather attributes
        $atts = array(
            'post_title' => $term->name,
            'post_type' => $this->POST_TYPE,
            'post_status' => 'publish',
            'post_content' => $term->description,
            'post_excerpt' => $term->description,
            'post_name' => $term->slug
        );
        if ( $taxonomy == 'post_tag' ) {
            $atts[ 'tags_input' ] = array( $term->slug );
        };
        if ( $taxonomy == 'category' ) {
            $atts[ 'post_category' ] = array( $term_id );
        }
        wp_insert_post( $atts );
    }
    
    function update_topic($term_id, $tt_id, $taxonomy) {
        $term = get_term( $term_id, $taxonomy );
        $topic = $this->get_topic($term, $taxonomy);
        error_log('Updating topic: ' . $topic->post_title);
    }
    
    function get_topic($term, $taxonomy) {
        // get a topic (post type) for a given term
        // creating one if it doesn't already exist
        $args = array(
            'post_name' => $term->slug,
            'post_type' => $this->POST_TYPE,
            'numberposts' => 1
        );
        
        if ($taxonomy == 'category') {
            $args['cat'] = $term->term_id;
        } elseif ($taxonomy == 'post_tag') {
            $args['tag'] = $term->slug;
        }
        
        $topics = new WP_Query($args);
        if ($topics->post_count === 0) {
            return $this->create_topic($term_id, $tt_id, $taxonomy);
        }
        
        $topic = $topics->posts[0];
        return $topic;
    }
    
    function save_post($post_id) {
        // we only care about topics
        if (get_post_type($post_id) !== $this->POST_TYPE) return;
        
        // convert old links, but only once
        /***
        if (!get_post_meta($post_id, '_links_converted', true)) {
            $old_links = $this->convert_old_links($post_id);
        }
        
        // links
        if ( isset($_POST['topic_links']) ) {
            $links = get_post_meta($post_id, 'topic_links', true);
            foreach($_POST['topics_links'] as $i => $link) {
                if (isset($_POST['topic_links'][$i]['url'])) {
                    $links[$i] = $link;
                }
            }
        }
        ***/
    }
    
    function register_admin_scripts() {
        $jslibs = array(
            'underscore' => plugins_url('js/underscore-min.js', __FILE__),
            'backbone' => plugins_url('js/backbone-min.js', __FILE__),
        );
        
        wp_enqueue_script( 'underscore', $jslibs['underscore']);
        wp_enqueue_script( 'backbone', $jslibs['backbone'],
            array('underscore', 'jquery'));
    }
    
    
    function convert_old_links($post_id, $delete=false) {
        $links = (array)get_post_meta($post_id, 'topic_links', true);
        $fields = array( 'title', 'url', 'source' );
        foreach( range(0, 4) as $i ) {
            $link = array();
            foreach( $fields as $field ) {
                $name = "link_" . $i . "_" . $field;
                $link[$field] = get_post_meta( $post_id, $name, true );
                if ($delete) {
                    error_log('Deleting ' . $name);
                    delete_post_meta($post_id, $name, $link[$field]);
                }
            }
            $links[] = $link;
        }
        // update_post_meta()
        return $links;
    }
}

$sw_topics = new SI_Topics;

class SW_Topics_Walker extends Walker {
    
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    function start_el( &$output, $item, $depth, $args ) {
        if ($item->menu_order > 3) return;
        if ($item->menu_order == 1) $counter = 'alpha';
        if ($item->menu_order == 3) $counter = 'omega'; 
    	$obj = get_post( $item->object_id );
    	if ( $obj->post_type == "topic" ) {
    	    // get term for topic, use term permalink
    	}
    	$output .= '<div class="grid_4 ' . $counter . ' topic">';
    	if ( has_post_thumbnail( $obj->ID ) ) {
    	    $output .= '<a href="'. get_permalink( $obj->ID ) . '">' . get_the_post_thumbnail( $obj->ID, array(140, 140) ) . '</a>';
    	}
    	$output .= '	<h3><a href="'. get_permalink( $obj->ID ) . '">' . $obj->post_title . '</a></h3>';
    }
    
    function end_el( &$output, $item, $depth ) {
        if ($item->menu_order > 3) return;
        $output .= '	</div>';
    }
}

function sw_get_topic_featured_links($post) {
    $results = array();
    $fields = array( 'title', 'url', 'source' );
    foreach( range(0, 4) as $i ) {
        $link = array();
        foreach( $fields as $field ) {
            $name = "link_" . $i . "_" . $field;
            $link[$field] = get_post_meta( $post->ID, $name, true );
        }
        $results[$i] = $link;
    }
    
    return $results;
}


?>