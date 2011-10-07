<?php
add_action( 'init', 'sw_topic_setup' );
function sw_topic_setup() {
    if (has_action( 'edited_term', 'argo_create_topic_page' )) {
        remove_action( 'edited_term', 'argo_create_topic_page' );
    }
    
    if (has_action( 'save_post', 'argo_update_topic_taxonomy' )) {
        remove_action( 'save_post', 'argo_update_topic_taxonomy' );
    }
}

add_action( 'init', 'sw_setup_menus' );
function sw_setup_menus() {
    $location = 'featured-topics';
    $label = __('Featured Topics');
    register_nav_menus(array(
        $location => $label
    ));
    
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
    	    $output .= get_the_post_thumbnail( $obj->ID, array(140, 140) );
    	}
    	$output .= '	<h3><a href="'. sw_get_topic_permalink( $obj ) . '">' . $obj->post_title . '</a></h3>';
    }
    
    function end_el( &$output, $item, $depth ) {
        if ($item->menu_order > 3) return;
        $output .= '	</div>';
    }
}

// post admin
add_action( 'add_meta_boxes', 'sw_topic_term_metabox' );
function sw_topic_term_metabox() {
    add_meta_box( 'topic-term', 'Term', 'sw_show_topic_term',
                 'topic', 'side', 'high');
}

function sw_get_term_for_topic($post) {
    $term = get_the_category($post->ID);
    if (! $term ) {
        $term = get_the_tags( $post->ID ); }
    if ($term) { 
        return $term[0]; 
    } else {
        return false;
    }
}

function sw_show_topic_term($post) { 
    $term = sw_get_term_for_topic($post);
    if ($term): ?>
    <h4><?php echo $term->name; ?></h4>
    <p>Content for this topic buildout will show up with this term.</p>
    <?php endif;
}

function sw_get_topic_permalink($post) {
    $term = sw_get_term_for_topic($post);
    if ($term) {
        return get_term_link($term, $term->taxonomy);
    } else {
        return '';
    }
}

// topic links
add_action( 'add_meta_boxes', 'sw_topic_links_metabox' );
function sw_topic_links_metabox() {
    add_meta_box( 'featured-links', 'Featured Links', 'sw_featured_links',
                  'topic', 'normal', 'high');
}

function sw_featured_links($post) { ?>
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

add_action( 'save_post', 'sw_update_topic_links' );
function sw_update_topic_links($post_id) {
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

function sw_get_topics_for_post($post_id) {
    $built = array();
    $bare = array();
    $terms = wp_get_object_terms($post_id, array('post_tag', 'category'));
    foreach($terms as $term) {
        $topic = argo_get_topic_for($term);
        error_log( $topic->post_title );
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
    <div id="taxonomy">
        <?php if ($topics): ?>
        <div class="topics">
            <h4>Featured Topics</h4>
            <ul>
            <?php foreach ($topics as $i => $topic): ?>
                <li class="topic clearfix">
                <?php echo get_the_post_thumbnail($topic->ID, 'thumbnail', array('class'=>'alignleft')); ?>
                <h3><a href="<?php echo get_permalink($topic); ?>"><?php echo apply_filters('the_title', $topic->post_title); ?></a></h3>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <div class="terms">
            <h4>More Topics</h4>
            <ul>
                <?php foreach($terms as $i => $term): ?>
                    <li class="post-tag-link"><a href="<?php echo get_term_link($term->name, $term->taxonomy); ?>"title="<?php echo $term->name; ?>"><?php echo $term->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php
}

?>