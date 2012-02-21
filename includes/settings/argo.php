<?php
/* 
 * ARGO SETTINGS
 */
function argo_add_options_page() {
    add_options_page( 'Argo', 'Argo', 'manage_options',
                      'argo', 'argo_options_page' );
}
add_action( 'admin_menu', 'argo_add_options_page' );

function argo_options_page() {
?>
    <div>
        <h2>Argo settings</h2>
        <form action="options.php" method="post">

            <?php settings_fields( 'argo' ); ?>
            <?php do_settings_sections( 'argo' ); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div>
<?php
}

function argo_settings_init() {
    add_settings_section( 'argo_settings', 'Argo settings', 'argo_settings_section_callback', 'argo' );

    add_settings_field( 'django_admin_url', 'Django Admin URL', 
        'argo_django_admin_url_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'django_admin_url' );

    add_settings_field( 'django_app_name', 'Django App Name', 
        'argo_django_app_name_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'django_app_name' );

    add_settings_field( 'show_email_link', 'Show E-mail Link', 
        'argo_show_email_link_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'show_email_link' );
    
}
add_action( 'admin_init', 'argo_settings_init' );

function argo_settings_section_callback() {
    echo '<p>Argo-specific settings.</p>';
}

function argo_django_admin_url_callback() {
    $option = get_option( 'django_admin_url' );
    echo "<input type='text' value='$option' name='django_admin_url' />"; 
}

function argo_django_app_name_callback() {
    $option = get_option( 'django_app_name' );
    echo "<input type='text' value='$option' name='django_app_name' />"; 
}

function argo_show_email_link_callback() {
    $option = get_option( 'show_email_link' );
    $checked = ( $option ) ? 'checked' : '';
    echo "<input type='checkbox' value='show' name='show_email_link' $checked /> ";
}

/*
 * SETTINGS PANEL
 */
function argo_add_agg_options_page() {
    add_options_page( 'Social Media', 'Social Media', 
                       'manage_options', 'agg', 'agg_options_page' );
}
add_action( 'admin_menu', 'argo_add_agg_options_page' );

function agg_options_page() {
?>
    <div>
        <h2>Social Media settings</h2>
        <form action="options.php" method="post">

            <?php settings_fields('agg'); ?>
            <?php do_settings_sections('agg'); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div>
<?php
}

function argo_agg_settings_init() {
    add_settings_section( 'agg_settings', 'agg', 'argo_agg_section_callback', 'agg' );

    add_settings_field( 'facebook_link', 'Link to Facebook Profile', 
        'argo_facebook_link_callback', 'agg', 'agg_settings' );
    register_setting( 'agg', 'facebook_link' );

    add_settings_field( 'twitter_link', 'Link to Twitter Page', 
        'argo_twitter_link_callback', 'agg', 'agg_settings' );
    register_setting( 'agg', 'twitter_link' );

    add_settings_field( 'youtube_link', 'Link to YouTube Page', 
        'argo_youtube_link_callback', 'agg', 'agg_settings' );
    register_setting( 'agg', 'youtube_link' );

    add_settings_field( 'flickr_link', 'Link to Flickr Page', 
        'argo_flickr_link_callback', 'agg', 'agg_settings' );
    register_setting( 'agg', 'flickr_link' );

    add_settings_field( 'blogroll_link', 'Link to Blogroll Page', 
        'argo_blogroll_link_callback', 'agg', 'agg_settings' );
    register_setting( 'agg', 'blogroll_link' );
    
    add_settings_field( 'gplus_link', 'Link to Google Plus Page', 
        'argo_gplus_link_callback', 'agg', 'agg_settings' );
    register_setting( 'agg', 'gplus_link' );

    add_settings_field( 'podcast_link', 'Link to Podcast Feed',
        'argo_podcast_link_callback', 'agg', 'agg_settings' );
    register_setting( 'agg', 'podcast_link' );
}

add_action( 'admin_init', 'argo_agg_settings_init' );

function argo_agg_section_callback() {
    return '';
}

function argo_facebook_link_callback() {
    $option = get_option( 'facebook_link' );
    echo "<input type='text' value='$option' name='facebook_link' />"; 
}

function argo_twitter_link_callback() {
    $option = get_option( 'twitter_link' );
    echo "<input type='text' value='$option' name='twitter_link' />"; 
}

function argo_youtube_link_callback() {
    $option = get_option( 'youtube_link' );
    echo "<input type='text' value='$option' name='youtube_link' />"; 
}

function argo_flickr_link_callback() {
    $option = get_option( 'flickr_link' );
    echo "<input type='text' value='$option' name='flickr_link' />"; 
}

function argo_blogroll_link_callback() {
    $option = get_option( 'blogroll_link' );
    echo "<input type='text' value='$option' name='blogroll_link' />"; 
}

function argo_gplus_link_callback() {
    $option = get_option( 'gplus_link' );
    echo "<input type='text' value='$option' name='gplus_link' />"; 
}

function argo_podcast_link_callback() {
    $option = get_option( 'podcast_link' );
    echo "<input type='text' value='$option' name='podcast_link' />";
}

?>
