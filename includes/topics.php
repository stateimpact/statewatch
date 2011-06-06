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
?>