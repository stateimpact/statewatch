<?php
add_action( 'init', 'sw_create_station_post_types' );
function sw_create_station_post_types() {
    register_post_type( 'partner_station', 
        array(
            'labels' => array(
                'name' => 'Partners',
                'singular_name' => 'Partner',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Partner',
                'edit' => 'Edit',
                'edit_item' => 'Edit Partner',
                'view' => 'View',
                'view_item' => 'View Partner',
                'search_items' => 'Search Partners',
                'not_found' => 'No partners found',
                'not_found_in_trash' => 'No partners found in trash',
            ),
        'description' => 'Partners',
        'exclude_from_search' => true,
        'public' => false,
        'show_ui' => true,
        'supports' => array('title', 'excerpt', 'thumbnail', 'menu_order'),
        'taxonomies' => array(),
        )
    );
    
    add_image_size( 'station-thumb', 140, 9999, true);
};

add_action( 'add_meta_boxes', 'sw_add_station_metabox');
function sw_add_station_metabox() {
    add_meta_box( 'station_metadata', 'Partner Metadata', 
                  'sw_station_metabox', 'partner_station', 'normal', 'high');
};

function sw_station_metabox($post) {
    $freq = get_post_meta( $post->ID, 'frequency', true );
    $city = get_post_meta( $post->ID, 'city', true );
    $url = get_post_meta( $post->ID, 'url', true );
    $support_url = get_post_meta( $post->ID, 'support_url', true );
    $primary = get_post_meta( $post->ID, 'is_primary', true );
    $order = get_post_meta( $post->ID, 'menu_order', true);
    if (empty($order)) {
        $order = 0;
    }
    ?>
    <table class="form-tabel">
        <tr>
            <h4>Primary partners appear in the site footer and on the About page. Others appear only on the About page.</h4>
            <th><label for="is_primary"></label></th>
            <td>
                <div>
                    <input type="radio" name="is_primary" value="1" <?php checked($primary, 1); ?> /> Primary partner
                </div>
                <div>
                    <input type="radio" name="is_primary" value="2" <?php checked($primary, 2); ?> /> Supporting organization
                    <span class="description">Other editorial contributors, including other public radio stations</span>
                </div>
                <div>
                    <input type="radio" name="is_primary" value="3" <?php checked($primary, 3); ?> /> Sponsor
                    <span class="description">Financial contributors, such as local foundations</span>
                </div>
            </td>
        </tr>
        <tr>
            <th><label for="url">URL: </label></th>
            <td>
                <input type="text" name="url" value="<?php echo esc_attr( $url ); ?>"/>
                <span class="description">Organization's main URL</span>
            </td>
        </tr>
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
            <th><label for="support_url">Support URL: </label></th>
            <td>
                <input type="text" name="support_url" value="<?php echo esc_attr( $support_url ); ?>"/>
                <span class="description">Where can people give you money?</span>
            </td>
        </tr>
        <tr>
            <th><label for="menu_order">Order: </label></th>
            <td>
                <input type="text" name="menu_order" value="<?php echo esc_attr( $order ); ?>" />
                <span class="description">Lower numbers will show up first</span>
            </td>
        </tr>
    </table>
<?php 
}

add_action( 'save_post', 'sw_save_station_metadata' );
function sw_save_station_metadata($post_id) {
    $fields = array('frequency', 'city', 'url', 
        'support_url', 'is_primary', 'menu_order');
    foreach ($fields as $field) {
        if ( isset( $_POST[$field] ) ) {
            update_post_meta( $post_id, $field, 
                strip_tags( $_POST[$field] ));
        }
    };
}

function sw_get_stations() {
    $stations = new WP_Query(
            array(
                'post_type'      => 'partner_station',
                'orderby'        => 'menu_order title',
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

function sw_get_sponsors() {
    $sponsors = new WP_Query(
            array(
                'post_type'      => 'partner_station',
                'orderby'        => 'title',
                'order'          => 'ASC',
                'posts_per_page' => -1,
                'meta_key'       => 'is_primary',
                'meta_value'     => 3,
            )
        );
    
    return $sponsors;
}

?>