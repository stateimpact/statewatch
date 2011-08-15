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

?>