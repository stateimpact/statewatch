<?php

class SW_Sticky_Post_Types {
    
    function __construct() {
        $this->post_types = array('fusiontablesmap');
        
        add_action( 'add_meta_boxes', array(&$this, 'add_meta_boxes') );
    }
    
    function add_meta_boxes() {
        foreach($this->post_types as $type) {
            $post_type = get_post_type_object($type);
            add_meta_box('sticky', 'Stick This ' . $post_type->labels->singular_name,
            array(&$this, 'render_sticky_meta_box'), 
            $type, 'side', 'high');
        }
    }
    
    function render_sticky_meta_box($post) {
        $sticky = is_sticky($post->ID);
        ?>
        <span id="sticky-span">
            <input id="sticky" name="sticky" 
            type="checkbox" value="sticky" 
            <?php checked($sticky, true); ?> tabindex="4"> 
            <label for="sticky" class="selectit">Stick this post to the front page</label>
            <br>
        </span>
        <?php
    }
}

new SW_Sticky_Post_Types;
?>