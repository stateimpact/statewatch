<?php
add_action('widgets_init', 'sw_add_widgets');
function sw_add_widgets() {
    register_widget( 'About_StateImpact' );
}


class About_StateImpact extends WP_Widget_Text {
    
    function About_StateImpact() {
        $site_title = get_option('blogname', 'StateImpact');
        $widget_opts = array(
            'classname' => 'sw-about',
            'description' => 'About StateImpact'
        );
        $this->WP_Widget( 'about-widget', "About $site_title", $widget_opts);
    }
        
	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
			<div class="textwidget"><?php echo $instance['filter'] ? wpautop($text) : $text; ?></div>
            <ul class="sw-social clearfix">
                <?php if ( get_option( 'twitter_link' ) ) : ?>
                    <li class="sw-twitter">
                        <a href="<?php echo get_option( 'twitter_link' ); ?>">Twitter</a>
                    </li> 
                <?php endif; ?>
                <?php if ( get_option( 'facebook_link' ) ) : ?>
                    <li class="sw-fb">
                        <a href="<?php echo get_option( 'facebook_link' ); ?>">Facebook</a>
                    </li>
                <?php endif ?> 
                
                <li class="sw-rss"><?php echo the_feed_link( 'RSS' ); ?></li>
            </ul> 
            
            <ul class="sw-info clearfix"> 
                <?php if ( get_option( 'support_url' ) ): ?>
                    <li><a href="<?php echo get_option( 'support_url' ); ?>">Support <?php bloginfo( 'name' ); ?></a></li>
                <?endif; ?>
                <li><a href="<?php echo get_option('about_link', get_option( 'url') . 'about/'); ?>">Learn more about <?php bloginfo( 'name' ); ?></a></li> 
            </ul> 

            <form role="search" method="get"> 
            	<div><label class="visuallyhidden" for="s1">Search for:</label> 
            	<input type="text" placeholder="Search <?php bloginfo( 'name' ); ?>" value="" name="s" class="sw-about-search" /> 
            	<input type="image" src="<?php bloginfo( 'template_url' )?>/img/btn-go.png" alt="Submit" width="32" height="24" id="search-submit" /> 
            	</div> 
            </form> 
        
		<?php
		echo $after_widget;
	}
    
}

?>