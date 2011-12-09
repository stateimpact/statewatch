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
        add_action('created_term', array($this, 'create_topic'), 10, 2);
        
        // update topic on edited_term
        add_action('edited_term', array($this, 'update_topic'), 10, 3);
        
        // save links on save_post, fixing old data model if needed
        add_action('save_post', array($this, 'save_post'));
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
            'taxonomies' => array( 'feature', 'post_tag', 'category' ),
        ) );
    }
    
    function create_topic($term_id, $tt_id) {
        
    }
    
    function update_topic($term_id, $tt_id, $taxonomy) {
        
    }
    
    function save_post($post_id) {
        // we only care about topics
        if (get_post_type($post_id) !== $this->POST_TYPE) return;
        
        // convert old links, but only once
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
        update_post_meta()
        return $links;
    }
}

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


?>