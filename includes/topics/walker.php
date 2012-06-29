<?php
class SW_Topics_Walker extends Walker {
    
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    function start_el( &$output, $item, $depth, $args ) {
        if ($item->menu_order > 3) return;
        if ($item->menu_order == 1) $counter = 'alpha';
        if ($item->menu_order == 3) $counter = 'omega'; 
    	$obj = get_post( $item->object_id );
    	if ( $obj->post_type == "topic" ) {
    	    // get term for topic, use term permalink
    	}
    	$output .= '<div class="grid_4 ' . $counter . ' topic">';
    	if ( has_post_thumbnail( $obj->ID ) ) {
    	    $output .= '<a href="'. get_permalink( $obj->ID ) . '">' . get_the_post_thumbnail( $obj->ID, array(140, 140) ) . '</a>';
    	}
    	$output .= '	<h3><a href="'. get_permalink( $obj->ID ) . '">' . $obj->post_title . '</a></h3>';
    }
    
    function end_el( &$output, $item, $depth ) {
        if ($item->menu_order > 3) return;
        $output .= '	</div>';
    }
}

?>