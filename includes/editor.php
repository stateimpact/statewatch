<?php
define( 'HALF_WIDTH', 300 );
/*
 * TINYMCE CUSTOMIZATIONS
 */

function add_argo_mce_plugin( $plugin_array ) {
    // XXX: gross path assumption
    $plugin_array[ 'modulize' ] = navis_get_theme_script_url( 'tinymce/plugins/argo/editor_plugin.js' );
    return $plugin_array;
}

function register_argo_mce_buttons( $buttons ) {
    array_push( $buttons, "|", "modulize" );
    return $buttons;
}

function argo_add_mce_buttons() {
    if ( get_user_option( 'rich_editing' ) == true ) {
        add_filter( 'mce_external_plugins', 'add_argo_mce_plugin', 4 );
        add_filter( 'mce_buttons', 'register_argo_mce_buttons', 4 );
    }
}

add_action( 'init', 'argo_add_mce_buttons' );


/*
 * EDITOR MARKUP CUSTOMIZATIONS
 */

/*
 * DISABLE DEFAULT FUNCTIONALITY
 */

function disable_builtin_caption( $shcode, $html ) {
    return $html;
}
//add_filter( 'image_add_caption_shortcode', 'disable_builtin_caption', 15, 2 );
/*
 * END DISABLE DEFAULT FUNCTIONALITY
 */

/*
 * AUDIO EDITOR MARKUP CUSTOMIZATIONS
 */
function argo_audio_editor_markup( $href, $title, $caption ) {
    // XXX: need better place for this

    /*
    $args = array(
        'order'          => 'ASC',
        'orderby' 		 => 'menu_order',
        'post_type'      => 'attachment',
        'post_parent'    => $post->ID,
        'post_mime_type' => 'audio',
        'post_status'    => null,
        'numberposts'    => -1,
        'size' => 'large',
    );

    $attachments = get_posts($args);
    if ($attachments) {
        foreach ($attachments as $attachment) {
            $title = $attachment->post_title;
            $caption = $attachment->post_excerpt;
            $description = $attachment->post_content;
            $url = $attachment->guid;
        }
    }
     */
    $out = sprintf( '<ul class="%s"><li>', 'playlist' );
    $out .= sprintf( '<a href="%s" class="%s" title="%s">%s', $href, 'inline', $title, $title );
    if ( $caption ) {
        $out .= sprintf( '<span class="%s">%s</span></a>', 'caption', $caption );
    }
    $out .= sprintf( '<a href="%s" class="%s">%s</a>', $href, 'exclude', 'Download' );
    $out .= "</li></ul>";

    return $out;
}

/*
 * SHORTCODES
 */
function argo_audio_shortcode( $atts, $content ) {
	extract( $atts );
	
	$html = argo_audio_editor_markup( $href, $title, $content );
	return $html;
}

// construct shortcode for audio embeds
function argo_audio_editor_shortcode( $html, $href, $title  ) {
	return sprintf( '[audio href="%s" title="%s"]Insert caption here[/audio]', $href, $title );
}

// add_shortcode( 'audio', 'argo_audio_shortcode' );
// add_filter( 'audio_send_to_editor_url', 'argo_audio_editor_shortcode', 10, 3 );

function module_shortcode( $atts, $content, $code ) {
    extract( shortcode_atts( array(
        'align' => 'left',
        'width' => 'half',
        'type' => 'aside',
    ), $atts ) );

    $wrapped = sprintf( '<div class="module %s %s %s">%s</div>',
        $type, $align, $width, $content );
    return $wrapped;
}
add_shortcode( 'module', 'module_shortcode' );
/*
 * END SHORTCODES
 */

/*
 * OEMBED
 */
function argo_wrap_oembed( $html, $url, $attr ) {
    // wrap in our own fancy div
    $width = $attr['width'] <= HALF_WIDTH ? 'left half' : 'full';
    $out = sprintf( '<div class="module video %s">', $width );
    $out .= $html . '</div>';
    return $out;
}
//add_filter( 'embed_oembed_html', 'argo_wrap_oembed', 10, 3 );

/*
 * ADMIN PRESENTATION CUSTOMIZATIONS
 */
function argo_tweak_upload_tabs( $defaults ) {
    if ( array_key_exists( 'gallery', $defaults ) ) {
        unset( $defaults[ 'gallery' ] );
    }
    return $defaults;
}
// XXX: it does more harm than good to comment this out.
//add_filter( 'media_upload_tabs', 'argo_tweak_upload_tabs', 12, 1 );


/*
 * END ADMIN PRESENTATION CUSTOMIZATIONS
 */


?>
