<?php
/**
* Custom walker for Featured Topics Area
* This class replaces the previous SW_Topics_Walker
* to allow both Topic and Multimedia post types.
*/
class SW_Featured_Topics_Walker extends Walker_Nav_Menu {
    // three-item limit is like the world's stingiest express lane
    public $item_limit = 3;

    function start_el( &$output, $item, $depth, $args ) {
        if ($item->menu_order > $this->item_limit) return;

        switch ($item->menu_order) {
            case 1:
                $counter = "alpha";
                break;
            
            case 3:
                $counter = "omega";
                break;

            default:
                $counter = "";
                break;
        }

        // the thing we're actually talking about
        $obj = get_post($item->object_id);
        $permalink = get_permalink($obj->ID);
        $title = apply_filters('the_title', $obj->post_title);

        $output .= "<div class=\"grid_4 $counter topic\">";
        if ( has_post_thumbnail($obj->ID) ) {
            $thumb = get_the_post_thumbnail( $obj->ID, array(140, 140) );
            $output .= "<a href=\"$permalink\">$thumb</a>";
        }
        $output .= "<h3><a href=\"$permalink\">$title</a></h3>";
    }

    function end_el( &$output, $item, $depth ) {
        if ($item->menu_order > 3) return;
        $output .= "</div>";
    }

}

?>