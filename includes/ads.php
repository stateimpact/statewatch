<?php

/*
 * SETTINGS PANEL
 */
function argo_add_ads_options_page() {
    add_options_page( 'Advertising', 'Advertising', 'manage_options',
                      'ads', 'ads_options_page' );
}
add_action( 'admin_menu', 'argo_add_ads_options_page' );

function ads_options_page() {
?>
    <div>
        <h2>Advertising settings</h2>
        <form action="options.php" method="post">

            <?php settings_fields('ads'); ?>
            <?php do_settings_sections('ads'); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div>
<?php
}

function argo_ads_settings_init() {
    add_settings_section( 'ads_settings', 'Ads', 'argo_ads_section_callback', 'ads' );

    add_settings_field( 'ad_setup_code', 'Ad setup code', 
        'argo_ad_setup_code_callback', 'ads', 
        'ads_settings' );
    register_setting( 'ads', 'ad_setup_code' );

    add_settings_field( 'ad_placement_code', 'Ad placement code', 
        'argo_ad_placement_code_callback', 'ads', 
        'ads_settings' );
    register_setting( 'ads', 'ad_placement_code' );

    add_settings_field( 'ad_placement_code', 'Ad placement code', 
        'argo_ad_placement_code_callback', 'ads', 
        'ads_settings' );
    register_setting( 'ads', 'ad_placement_code' );

    add_settings_field( 'ad_heading_message', 'Ad heading message', 
        'argo_ad_heading_message_callback', 'ads', 
        'ads_settings' );
    register_setting( 'ads', 'ad_heading_message' );

    add_settings_field( 'ad_sponsor_message', 'Ad sponsor message', 
        'argo_ad_sponsor_message_callback', 'ads', 
        'ads_settings' );
    register_setting( 'ads', 'ad_sponsor_message' );

    add_settings_field( 'ad_sponsor_url', 'Ad sponsor URL', 
        'argo_ad_sponsor_url_callback', 'ads', 
        'ads_settings' );
    register_setting( 'ads', 'ad_sponsor_url' );
}

add_action( 'admin_init', 'argo_ads_settings_init' );

function argo_ads_section_callback() {
    return '';
}

function argo_ad_setup_code_callback() {
    $option = get_option( 'ad_setup_code' );
    echo "<textarea name='ad_setup_code' rows='6' cols='40'>$option</textarea>";
}

function argo_ad_placement_code_callback() {
    $option = get_option( 'ad_placement_code' );
    echo "<textarea name='ad_placement_code' rows='6' cols='40'>$option</textarea>";
}

function argo_ad_heading_message_callback() {
    $option = get_option( 'ad_heading_message' );
    echo "<input type='text' value='$option' name='ad_heading_message' />";
}

function argo_ad_sponsor_message_callback() {
    $option = get_option( 'ad_sponsor_message' );
    echo "<input type='text' value='$option' name='ad_sponsor_message' />";
}

function argo_ad_sponsor_url_callback() {
    $option = get_option( 'ad_sponsor_url' );
    echo "<input type='text' value='$option' name='ad_sponsor_url' />";
}


/*
 * AD SETUP FILTER
 */
function argo_add_ad_placement_code() {
    $ad_setup = get_option( 'ad_setup_code' );
    if ( strlen( $ad_setup ) ) {
        echo $ad_setup;
    }
}
add_action( 'wp_head', 'argo_add_ad_placement_code' );

/*
 * WIDGET
 */
function argo_load_ad_widget() {
    register_widget( 'Ad_Widget' );
}

class Ad_Widget extends WP_Widget {
    function Ad_Widget() {
        $this->WP_Widget( 'ad-widget', $name = 'Ad Widget' );
    }

    function widget( $args, $instance ) {
        $boilerplate = get_option( 'ad_placement_code' );
        $station = ( get_option( 'call_letters' ) ) ?
            get_option( 'call_letters' ) :
                get_bloginfo( 'name' );

        // Get the header message or use a default
        $heading_message = ( get_option( 'ad_heading_message' ) ) ?
            sprintf( get_option( 'ad_heading_message' ), $station ) :
               "Support for " . $station . " is provided by:";

        $sponsor_url = get_option( 'ad_sponsor_url' );
        if ( $sponsor_url ) {
            $sponsor_message = ( get_option( 'ad_sponsor_message' ) ) ?
                sprintf( get_option( 'ad_sponsor_message' ), $station ) :
                   "Become a sponsor of " . $station;
        }

        // Only render if we have a position
        if ( array_key_exists( 'position', $instance ) ):
?>
       
         <li><div class="ad">
            <p><?php echo $heading_message; ?></p>
<?php 
            printf( $boilerplate, $instance[ 'position' ] ); 
            if ( $sponsor_url ):
?> 
                <p><a href="<?php echo $sponsor_url; ?>" title="sponsor"><?php echo $sponsor_message; ?></a></p>

<?php
            endif;

?>
        </div></li>
<?php
        endif;
        
    }
        
    function form( $instance ) {
        $defaults = array(
            'position' => '',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $fields = array(
            'position' => array(
                'id' => $this->get_field_id( 'position' ),
                'value' =>  esc_attr( $instance[ 'position' ] ),
                'title' => 'Position',
                'name' => $this->get_field_name( 'position' ),
            ),
        );

        foreach ($fields as $field) {
        ?>
            <p><label for="<?php echo $field['id']; ?>"><?php echo $field['title']; ?></label>
            <input class="widefat" id="<?php echo $field['id']; ?>" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>" />
            </p>
        <?php
        }
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['position'] = strip_tags( $new_instance[ 'position' ] );
        return $instance;
    }
}

add_action( 'widgets_init', 'argo_load_ad_widget' );

?>
