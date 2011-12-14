<?php
class SW_Fancybox {
    
    function __construct() {
        // edit image link tag
        // insert stylesheet
        // insert scripts
        
        add_action('wp_enqueue_scripts', array(&$this, 'add_scripts'));
        add_action('wp_print_styles', array(&$this, 'add_stylesheet'));
        
        $this->root = get_bloginfo( 'stylesheet_directory' );
    }
    
    
    function add_stylesheet() {
        $src = $this->root . '/js/fancybox/jquery.fancybox-1.3.4.css';
        wp_enqueue_style('fancybox', $src, array(), '1.3.4');
    }
    
    function add_scripts() {
        $js = array(
            'fancybox' => $this->root . "/js/fancybox/jquery.fancybox-1.3.4.js",
            'config' => $this->root . "/js/fancybox.config.js"
        );
        
        wp_enqueue_script('fancybox', $js['fancybox'], 
            array('jquery'), '1.3.4');
        
        wp_enqueue_script('fancybox_config', $js['config'], 
            array('jquery', 'fancybox'), '0.1');
    }    
}

new SW_Fancybox;

function sw_the_first_image($post_id, $attrs) {
    $defaults = array(
        'size'=>'thumbnail',
        'class'=>'current alignleft'
    );
    $attrs = wp_parse_args($attrs, $defaults);
	
	$args = array(
    	'numberposts' => 1,
    	'order'=> 'ASC',
    	'post_mime_type' => 'image',
    	'post_parent' => $post_id,
    	'post_status' => null,
    	'post_type' => 'attachment'
	);
	
	$attachments = get_children($args);

	if ($attachments) {
		foreach($attachments as $attachment) {
			$image_attributes = wp_get_attachment_image_src( $attachment->ID, $attrs['size'] )  ? wp_get_attachment_image_src( $attachment->ID, $attrs['size'] ) : wp_get_attachment_image_src( $attachment->ID, 'full' );
			echo "<img src=\"{wp_get_attachment_thumb_url($attachment->ID)}\" class=\"{$args['class']}\">";
		}
	}
}

?>