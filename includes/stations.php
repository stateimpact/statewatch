<?php
add_action( 'init', 'sw_create_station_post_types' );
function sw_create_station_post_types() {
    register_post_type( 'partner_station', 
        array(
            'labels' => array(
                'name' => 'Partner Stations',
                'singular_name' => 'Partner Station',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Station',
                'edit' => 'Edit',
                'edit_item' => 'Edit Station',
                'view' => 'View',
                'view_item' => 'View Station',
                'search_items' => 'Search Stations',
                'not_found' => 'No stations found',
                'not_found_in_trash' => 'No stations found in trash',
            ),
        'description' => 'Partner Stations',
        'exclude_from_search' => true,
        'public' => false,
        'show_ui' => true,
        'supports' => array('title', 'excerpt', 'thumbnail'),
        'taxonomies' => array(),
        )
    );
    
    add_image_size( 'station-thumb', 140, 9999, true);
};

add_action( 'add_meta_boxes', 'sw_add_station_metabox');
function sw_add_station_metabox() {
    add_meta_box( 'station_metadata', 'Station Metadata', 
                  'sw_station_metabox', 'partner_station', 'normal', 'high');
};

function sw_station_metabox($post) {
    $freq = get_post_meta( $post->ID, 'frequency', true );
    $city = get_post_meta( $post->ID, 'city', true );
    $url = get_post_meta( $post->ID, 'url', true );
    $support_url = get_post_meta( $post->ID, 'support_url', true );
    $primary = get_post_meta( $post->ID, 'is_primary', true );
    ?>
    <table class="form-tabel">
        <tr>
            <th><label for="frequency">Frequency: </label></th>
            <td>
                <input type="text" name="frequency" value="<?php echo esc_attr( $freq ); ?>"/>
                <span class="description">For example, "88.5 FM"</span>
            </td>
        <tr>
            <th><label for="city">City: </label></th>
            <td>
                <input type="text" name="city" value="<?php echo esc_attr( $city ); ?>"/>
                <span class="description">For example, "Washington, DC"</span>
            </td>
        </tr>
        <tr>
            <th><label for="url">URL: </label></th>
            <td>
                <input type="text" name="url" value="<?php echo esc_attr( $url ); ?>"/>
                <span class="description">Your station's main URL</span>
            </td>
        </tr>
        <tr>
            <th><label for="support_url">Support URL: </label></th>
            <td>
                <input type="text" name="support_url" value="<?php echo esc_attr( $support_url ); ?>"/>
                <span class="description">Where can people give you money?</span>
            </td>
        </tr>
        <tr>
            <th><label for="is_primary"></label></th>
            <td>
                <div><input type="radio" name="is_primary" value="1" <?php checked($primary, 1); ?> /> Primary partner</div>
                <div><input type="radio" name="is_primary" value="2" <?php checked($primary, 2); ?> /> Supporting organization</div>
                <span class="description">Primary partners appear in the site footer. Others appear on the About page.</span>
            </td>
        </tr>
    </table>
<?php 
}

add_action( 'save_post', 'sw_save_station_metadata' );
function sw_save_station_metadata($post_id) {
    $fields = array('frequency', 'city', 'url', 'support_url', 'is_primary');
    foreach ($fields as $field) {
        update_post_meta( $post_id, $field, 
            strip_tags( $_POST[$field] ));
    };
}

function sw_get_stations() {
    $stations = new WP_Query(
            array(
                'post_type'      => 'partner_station',
                'orderby'        => 'title',
                'order'          => 'ASC',
                'meta_key'       => 'is_primary',
                'meta_value'     => 1,
                'posts_per_page' => -1
            )
        );
    
    return $stations;
}

function sw_get_supporting_orgs() {
    $partners = new WP_Query(
            array(
                'post_type'      => 'partner_station',
                'orderby'        => 'title',
                'order'          => 'ASC',
                'posts_per_page' => -1,
                'meta_key'       => 'is_primary',
                'meta_value'     => 2,
            )
        );
    
    return $partners;
}

?>