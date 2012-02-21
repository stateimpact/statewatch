<?php
add_action( 'admin_menu', 'sw_add_options_page' );
function sw_add_options_page() {
    add_options_page( 'StateImpact', 'StateImpact', 'manage_options', 
                      'statewatch', 'sw_options_page' );
}

function sw_options_page() { ?>
    <div>
        <h2>StateImpact settings</h2>
        <form action="options.php" method="post">

            <?php settings_fields('statewatch'); ?>
            <?php do_settings_sections('statewatch'); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div> <?php
}

add_action( 'admin_init', 'sw_settings_init' );
function sw_settings_init() {
    add_settings_section( 'statewatch', 'statewatch', 'sw_section_callback', 'statewatch');
    
    add_settings_field( 'copyright_holder', 'Name of Copyright Holder',
        'sw_copyright_holder_callback', 'statewatch', 'statewatch' );
    register_setting( 'statewatch', 'copyright_holder' );
    
    add_settings_field( 'tos_link', 'Link to Terms of Use',
        'sw_tos_callback', 'statewatch', 'statewatch' );
    register_setting( 'statewatch', 'tos_link' );
    
    add_settings_field( 'privacy_link', 'Link to Privacy Policy',
        'sw_privacy_callback', 'statewatch', 'statewatch' );
    register_setting( 'statewatch', 'privacy_link' );
    
    add_settings_field( 'support_link', 'Link to Support Page', 
        'sw_support_link_callback', 'statewatch', 'statewatch' );
    register_setting( 'statewatch', 'support_link' );
    
    add_settings_field( 'meta_description', 'Custom meta description for home page',
        'sw_meta_description_callback', 'statewatch', 'statewatch');
    register_setting( 'statewatch', 'meta_description' );
}

function sw_section_callback() {}

function sw_copyright_holder_callback() {
    $option = get_option( 'copyright_holder' );
    echo "<input type='text' value='$option' name='copyright_holder' />"; 
}

function sw_tos_callback() {
    $option = get_option( 'tos_link' );
    echo "<input type='text' value='$option' name='tos_link' />"; 
}

function sw_privacy_callback() {
    $option = get_option( 'privacy_link' );
    echo "<input type='text' value='$option' name='privacy_link' />"; 
}

function sw_support_link_callback() {
    $option = get_option( 'support_link' );
    echo "<input type='text' value='$option' name='support_link' />"; 
}

function sw_meta_description_callback() {
    $option = esc_attr(get_option( 'meta_description' ));
    echo "<textarea name='meta_description'>$option</textarea>";
}

?>