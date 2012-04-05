<?php

class Feedburner_Widget extends WP_Widget {
    function Feedburner_Widget() {
        $widget_opts = array(
            'classname' => 'feedburner',
            'description' => 'Feedburner'
        );
    $this->WP_Widget( 'feedburner-subscribe-widget', 'Subscribe by Email', $widget_ops );
    }
    
    function widget($args, $instance) {
        extract( $args );
        $error = "<p class='error'>Please install and/or configure <strong>FeedBurner Stats by DevMD.com</strong></p>";
        if ( function_exists( 'devmdfbstats_plugin_menu' ) ) {
            $options = get_option('DEVMDFBSTATS');
            if ( $options && $options['uri'] != '' ) {
                $uri = $options['uri'];
                $blogname = apply_filters('navis_feedburner_blogname', get_option('blogname'));
                $title = apply_filters('navis_feedburner_widget_title', $blogname);
                $placeholder = apply_filters('navis_feedburner_placeholder', "email address");
                $placeholder = esc_attr( strip_tags( $placeholder ));
                $signup_form = "<h3 class='widget-title'>$title Email Updates</h3>
                        <p>Keep up to date with $blogname by subscribing to our email updates:</p>
                        
                        <form id='feedburner-subscribe-sidebar' class='feedburner sidebar'
                        action='http://feedburner.google.com/fb/a/mailverify' method='post' target='popupwindow' 
                        onsubmit='window.open('http://feedburner.google.com/fb/a/mailverify?uri=$uri', 'popupwindow', 'scrollbars=yes,width=550,height=520');
                        return true'>\n\n
                        <input type='text' name='email' placeholder='$placeholder' />\n
                        <input type='submit' value='Subscribe' class='widget-submit' /><p>\n
                        <input type='hidden' value='$uri' name='uri'/>\n
                        <input type='hidden' name='loc' value='en_US'/>\n
                        </form>";
            } else {
              $signup_form = $error;
            };
        } else {
            $signup_form = $error;
        };
        echo $before_widget;
        echo $signup_form;
        echo $after_widget;
    }
};

function fb_callback() {
    register_widget( 'Feedburner_Widget' );
};
add_action('widgets_init', 'fb_callback');

function feedburner_footer() {
    if ( function_exists( 'devmdfbstats_plugin_menu' ) ) {
        $options = get_option('DEVMDFBSTATS');
        if ( $options && $options['uri'] != '' ) {
            $uri = $options['uri'];
            $signup_form = "<div id='email-footer'>
                    <h4>Receive daily email updates</h4>
                    <form id='feedburner-subscribe-footer' class='feedburner sidebar'
                    action='http://feedburner.google.com/fb/a/mailverify' method='post' target='popupwindow' 
                    onsubmit='window.open('http://feedburner.google.com/fb/a/mailverify?uri=$uri', 'popupwindow', 'scrollbars=yes,width=550,height=520');
                    return true'>\n\n
                    <input type='text' name='email' placeholder='email address' />\n
                    <input type='submit' value='Subscribe' class='footer-submit' /><p>\n
                    <input type='hidden' value='$uri' name='uri'/>\n
                    <input type='hidden' name='loc' value='en_US'/>\n
                    </form>
                </div>";
            echo $signup_form;
        };
    };
};

add_action('navis_below_footer_bio', 'feedburner_footer');

?>