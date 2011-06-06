<?php
add_action( 'init', 'sw_topic_setup' );
function sw_topic_setup() {
    if ( has_action( 'save_post', 'argo_update_topic_taxonomy' ) ) {
        remove_action( 'save_post', 'argo_update_topic_taxonomy', 10, 2 );
    }
    
    if ( has_action( 'edited_term', 'argo_create_topic_page' ) ) {
        remove_action( 'edited_term', 'argo_create_topic_page', 10, 3 );
    }
}

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
            $value = $_POST[$name];
            update_post_meta( $post_id, $name, $value );
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

?>