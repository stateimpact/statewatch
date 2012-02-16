<?php

class SI_Topics {
    
    public $POST_TYPE = "topic";
    
    function __construct() {
        // unhook argo events
        add_action('init', array(&$this, 'unhook_argo_events'));
        
        // check for post type, create if necessary
        // push this down the stack to account for the parent theme
        add_action('init', array($this, 'create_post_type'), 15);
        
        // create topic on created_term
        add_action('created_term', array(&$this, 'create_topic'), 10, 3);
        
        // update topic on edited_term
        add_action('edited_term', array(&$this, 'update_topic'), 10, 3);
        
        // hide topic on delete_term
        add_action('deleted_term_relationships', array(&$this, 'disable_topic'), 10, 2);
        
        // metaboxes
        add_action('add_meta_boxes', array(&$this, 'add_metaboxes'));
        
        // save links on save_post, fixing old data model if needed
        add_action('save_post', array($this, 'save_post'));
        
        // include assets
        add_action( 'admin_print_scripts-post.php', 
            array( &$this, 'register_admin_scripts' )
        );
        add_action( 'admin_print_scripts-post-new.php', 
            array( &$this, 'register_admin_scripts' )
        );
        
        add_action( 
            'admin_print_styles-post.php', 
            array( &$this, 'add_admin_stylesheet' ) 
        );
        add_action( 
            'admin_print_styles-post-new.php', 
            array( &$this, 'add_admin_stylesheet' ) 
        );
        
        // ajax
        add_action('wp_ajax_get_posts_for_topic',
            array(&$this, 'ajax_fetch'));
        
        add_action('wp_ajax_get_featured_posts_for_topic',
            array(&$this, 'ajax_get_featured_posts'));
        
        add_action('wp_ajax_save_featured_posts',
            array(&$this, 'ajax_save'));
            
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
    
    function get_term_for_topic($topic) {
        $taxonomies = array('post_tag', 'category');
        $terms = wp_get_object_terms($topic->ID, $taxonomies);
        if (is_array($terms)) {
            return $terms[0];
        } else {
            return false;
        }
    }
    
    function ajax_fetch() {
        if (isset($_POST['post_parent'])) {
            $post_id = $_POST['post_parent'];
            $featured = get_post_meta($post_id, 'featured_posts', true);
            $categories = wp_get_object_terms($post_id, 'category', array('fields'=>'ids'));
            $tags = wp_get_object_terms($post_id, 'post_tag', array('fields'=>'ids'));
            $args = array();
            
            if ( $featured) { $args['post__not_in'] = $featured; }
            if ($categories) { $args['category__in'] = $categories; }
            if ($tags) { $args['tag__in'] = $tags; }
            if ($_POST['s']) { $args['s'] = $_POST['s']; }
            
            $posts = $this->query($args);
            header( "Content-Type: application/json" );
            echo json_encode($posts);
        } else {
            header( "Content-Type: application/json" );
            echo json_encode(array());
        }
        die();
    }
    
    function ajax_save() {
        if ($_POST['post_parent']) {
            $post_id = $_POST['post_parent'];
            $featured = $_POST['featured_posts'];
            if ($featured) {
                $featured = explode(',', $featured);
            }
            update_post_meta($post_id, 'featured_posts', $featured);
        } else {
            error_log("No post_parent");
        }
        die();
    }
    
    function ajax_get_featured_posts() {
        if ($_POST['post_parent']) {
            $post_id = $_POST['post_parent'];
            $ids = get_post_meta($post_id, 'featured_posts', true);
            $posts = array();
            if (is_array($ids)) { 
                foreach($ids as $i => $id) {
                    if (!$id) continue;
                    $post = get_post(intval($id));
            		$posts[] = array(
            			'id' => $post->ID,
            			'title' => trim( esc_html( strip_tags( get_the_title( $post ) ) ) ),
            			'permalink' => get_permalink( $post->ID ),
            			'date' => mysql2date(__( 'Y/m/d' ), $post->post_date),
            			'type' => $post->post_type,
            			'order' => $i
            		);
                }
            }
            header( "Content-Type: application/json" );
            echo json_encode($posts);
        }
        die();
    }
    
    function query( $args = array() ) {
        // borrowed rather shamelessly from wordpress itself
        // wp-admin/includes/internal-linking.php
        
    	$query = array(
    		'post_type' => array('post', 'roundup', 'fusiontablesmap'),
    		'suppress_filters' => true,
    		'update_post_term_cache' => false,
    		'update_post_meta_cache' => false,
    		'post_status' => 'publish',
    		'order' => 'DESC',
    		'orderby' => 'post_date',
    		'posts_per_page' => 50,
    	);
    	
    	$query = wp_parse_args($args, $query);

    	$args['pagenum'] = isset( $args['pagenum'] ) ? absint( $args['pagenum'] ) : 1;

    	if ( isset( $args['s'] ) )
    		$query['s'] = $args['s'];

    	$query['offset'] = $args['pagenum'] > 1 ? $query['posts_per_page'] * ( $args['pagenum'] - 1 ) : 0;

    	// Do main query.
    	$get_posts = new WP_Query;
    	$posts = $get_posts->query( $query );
    	// Check if any posts were found.
    	if ( ! $get_posts->post_count )
    		return array();

    	// Build results.
    	$results = array();
    	foreach ( $posts as $post ) {
    		if ( 'post' == $post->post_type )
    			$info = mysql2date( __( 'Y/m/d' ), $post->post_date );
    		else
    			$info = $pts[ $post->post_type ]->labels->singular_name;

    		$data = array(
    			'id' => $post->ID,
    			'title' => trim( esc_html( strip_tags( get_the_title( $post ) ) ) ),
    			'permalink' => get_permalink( $post->ID ),
    			'date' => mysql2date(__( 'Y/m/d' ), $post->post_date),
    		);
    		
    		if (has_post_thumbnail($post->ID)) {
    		    $thumbnail = wp_get_attachment_image_src(
    		        get_post_thumbnail_id($post->ID), '60x60');
    		    if (is_array($thumbnail)) {
    		        $data['thumbnail'] = $thumbnail[0];
    		    }
    		}
    		
    		$data['type'] = get_post_type($post->ID);
    		
    		$results[] = $data;
    	}

    	return $results;
    }
    
    
    function add_metaboxes() {
        add_meta_box('featured-posts', 'Featured Posts', array($this, 'featured_posts_form'),
                    'topic', 'normal', 'high');
        
        add_meta_box( 'featured-links', 'Featured Links', array($this, 'featured_links_form'),
                      'topic', 'normal', 'high');
        
        add_meta_box( 'topic-term', 'Term', array(&$this, 'topic_term_metabox'),
                    'topic', 'side', 'high');
    }
    
    function topic_term_metabox($post) {
        $term = $this->get_term_for_topic($post);
        if ($term): ?>
        <h4><?php echo $term->name; ?></h4>
        <p>Content for this topic buildout will show up with this term.</p>
        <?php endif;
    }
    
    function featured_posts_form($post) { 
        ?>
        <div id="featured-posts-wrapper">
            <div id="latest-wrapper">
                <p class="howto">Click a story to feature it on this topic page.</p>
                <div class="latest">
                    <h2>Latest</h2>
                    <div>
                        <input type="text" name="s" placeholder="Search posts" class="search">
                        <input type="button" value="Search" class="button">
                    </div>
                    <div id="latest"></div>
                </div>
            </div>
            <div id="featured-wrapper">
                <p class="howto">Drag to reorder stories. Click a headline to remove it from features.
                Only the <strong>first three</strong> stories will be shown.
                </p>
                <div class="featured">
                    <h2>Featured</h2>
                    <div id="featured"></div>
                </div>
            </div>
        </div>
        <script type="x-jst" id="story-template">
        <h4><a id="<%= id %>" class="toggle" href="#"><%= title %></a></h4>
        <span class="date"><%= date %></span> | 
        <a href="<%= permalink %>" target="_blank">View</a>
        </script>
        <script>
        var featuredstories = new FeaturedStories({ post_parent: <?php echo $post->ID ?> });
        </script>
        <?php
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
                
        /***
        $topics = new WP_Query(array(
            'post_name' => $term->slug,
            'post_type' => $this->POST_TYPE
        ));
        if ($topics->post_count > 0) {
            // we already have this topic, bail out
            return;
        }
        ***/
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
        $created = wp_insert_post( $atts, false );
        if ($created) {
            error_log('Created topic: ' . $atts['post_title']);
        }
    }
    
    function update_topic($term_id, $tt_id, $taxonomy) {
        $term = get_term( $term_id, $taxonomy );
        $topic = $this->get_topic($term, $taxonomy);
        error_log('Updating topic: ' . $topic->post_title);
    }
    
    function get_topic($term, $taxonomy) {
        // get a topic (post type) for a given term
        // creating one if it doesn't already exist
        // error_log('Getting topic for ' . $term->name);
        $args = array(
            'name' => $term->slug,
            'post_type' => $this->POST_TYPE,
            'posts_per_page' => 1
        );
        
        if ($taxonomy == 'category') {
            $args['cat'] = $term->term_id;
        } elseif ($taxonomy == 'post_tag') {
            $args['tag_id'] = $term->term_id;
        }
        
        $topics = new WP_Query($args);
        if ($topics->post_count === 0) {
            return $this->create_topic($term->term_id, null, $taxonomy);
        }
        
        $topic = $topics->posts[0];
        return $topic;
    }
    
    function disable_topic($object_id, $delete_terms) {
        // when the last term relationship is removed from a topic
        // make that topic draft status
        if (get_post_type($object_id) !== $this->POST_TYPE) return;
        
        $terms = wp_get_object_terms($object_id, array('category', 'post_tag'));
        if (!$terms || is_wp_error($terms)) {
            wp_update_post(array(
                'ID' => $object_id,
                'post_status' => 'draft'
            ));
        }
    }
    
    function uncategorize($post_id) {
        $tags = wp_get_object_terms($post_id, 'post_tag', 'id');
        if ($tags) {
            // remove all categories from this topic
            wp_set_post_categories($post_id, array());
        }
    }
    
    function save_post($post_id) {
        // we only care about topics
        if (get_post_type($post_id) !== $this->POST_TYPE) return;
        
        $this->uncategorize($post_id);
        
        $fields = array( 'title', 'url', 'source' );
        foreach( range(0, 4) as $i ) {
            foreach( $fields as $field ) {
                $name = "link_" . $i . "_" . $field;
                if ( isset($_POST[$name]) ) {
                    $value = $_POST[$name];
                    update_post_meta( $post_id, $name, $value );
                }
            }
        }
    }
    
    function add_admin_stylesheet() {
        global $post;
        if ($post->post_type === $this->POST_TYPE) {
            $css = get_stylesheet_directory_uri() . '/includes/topics/css/topics-admin.css';
            wp_enqueue_style(
                'topics-admin', $css, array(), '0.1'
            );
        }
    }
    
    function register_admin_scripts() {
        global $post;
        if ($post->post_type === $this->POST_TYPE) {
            $js = array(
                'underscore' => get_stylesheet_directory_uri() . '/js/underscore-min.js',
                'backbone' => get_stylesheet_directory_uri() . '/js/backbone-min.js',
                'featured-posts' => get_stylesheet_directory_uri() . '/includes/topics/js/featured-posts.js'
            );

            wp_enqueue_script( 'underscore', $js['underscore']);
            wp_enqueue_script( 'backbone', $js['backbone'],
                array('underscore', 'jquery'));
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'featured-posts', $js['featured-posts'], 
                array('underscore', 'backbone', 'jquery', 'jquery-ui-sortable'), '0.1');
            
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

function sw_get_topic_featured_posts($post_id) {
    $featured = (array)get_post_meta($post_id, 'featured_posts', true);
    
    if (count($featured)) {
        $posts = array();
        foreach(array_slice($featured, 0, 3) as $id) {
            if ($id) $posts[] = get_post($id);
        }
        return $posts;
    } else {
        return false;
    }
}

function sw_get_topic_multimedia($post_id) {
    $categories = wp_get_object_terms($post_id, 'category', array('fields'=>'ids'));
    $tags = wp_get_object_terms($post_id, 'post_tag', array('fields'=>'ids'));
    $args = array('post_type' => 'multimedia');
    
    if ($tags) { $args['tag__in'] = $tags; }
    elseif ($categories) { $args['category__in'] = $categories; }
    
    return new WP_Query($args);
}

function sw_get_topics_for_post($post_id) {
    $built = array();
    $bare = array();
    $terms = wp_get_object_terms($post_id, array('post_tag', 'category'));
    foreach($terms as $term) {
        $topic = argo_get_topic_for($term);
        if (has_post_thumbnail($topic->ID)) {
            $built[] = $topic;
        } else {
            $bare[] = $term;
        }
    }
    
    return array(
        'topics' => $built,
        'terms' => $bare
    );
}

add_action('after_the_content', 'sw_show_related_topics');
function sw_show_related_topics() {
    global $post;
    extract(sw_get_topics_for_post($post->ID));
    ?>
    <?php if ($topics || $terms): ?>
    <div id="taxonomy">
        <?php if ($topics): ?>
        <div class="topics">
            <h4>Featured Topics</h4>
            <ul>
            <?php foreach ($topics as $i => $topic): ?>
                <?php if ($topic->post_title): ?>
                    <li class="topic clearfix">
                        <a href="<?php echo get_permalink($topic); ?>"><?php echo get_the_post_thumbnail($topic->ID, 'thumbnail', array('class'=>'alignleft')); ?></a>
                    <h3><a href="<?php echo get_permalink($topic); ?>"><?php echo apply_filters('the_title', $topic->post_title); ?></a></h3>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if ($terms): ?>
        <div class="terms">
            <h4>More Topics</h4>
            <ul>
                <?php foreach($terms as $i => $term): 
                    if (is_wp_error($term)) continue; ?>
                    <li class="post-tag-link"><a href="<?php echo get_term_link($term, $term->taxonomy); ?>"title="<?php echo $term->name; ?>"><?php echo $term->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php
}


?>