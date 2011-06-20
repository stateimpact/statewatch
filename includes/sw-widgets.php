<?php
add_action('widgets_init', 'sw_add_widgets');
function sw_add_widgets() {
    register_widget( 'About_StateImpact' );
    register_widget( 'Impact_Network_Widget' );
}


class About_StateImpact extends WP_Widget {
    
    function About_StateImpact() {
		$site_title = SITE_NAME_PREFIX . get_option('blogname');
        $widget_opts = array(
            'classname' => 'sw-about',
            'description' => 'About StateImpact'
        );
        $this->WP_Widget( 'about-widget', "About $site_title", $widget_opts);
    }
        
	function widget( $args, $instance ) {
		extract($args);
		$site_title = SITE_NAME_PREFIX . get_option('blogname');
		$about = get_static_page('about');
		$title = apply_filters( 'widget_title', "About $site_title", $instance, $this->id_base);
		$text = apply_filters( 'widget_text', $about->post_content, $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo "<h3>$title</h3>"; } ?>
			
			<div class="textwidget"><?php echo $text; ?></div>
            
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
                <?php if ( get_option( 'support_link' ) ): ?>
                    <li><a href="<?php echo get_option( 'support_link' ); ?>">Support <?php echo SITE_NAME_PREFIX . get_bloginfo( 'name' ); ?></a></li>
                <?endif; ?>
                <li><a href="<?php echo get_permalink( $about->ID ); ?>">Learn more</a></li>
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

$SITES = array(
    'texas'         => 'Texas',
    'indiana'       => 'Indiana',
    'pennsylvania'  => 'Pennsylvania',
    'new-hampshire' => 'New Hampshire',
    'florida'       => 'Florida',        
    'ohio'          => 'Ohio',
    'oklahoma'      => 'Oklahoma',
    'idaho'         => 'Idaho'
);

class Impact_Network_Widget extends WP_Widget {
        
    function Impact_Network_Widget() {
        $widget_opts = array(
            'classname' => 'iog_network_news',
            'description' => __('StateImpact Network Highlights', 'network')
        );
        $this->WP_Widget( 'impact-network-widget', __('Impact Network Widget', 'network'), $widget_opts );
    }
    
    function get_site_info( $url ) {
        global $SITES;
        foreach ( $SITES as $state => $title ) {
            if ( preg_match( "/\/$state\//", $url ) ) {
                return array( $state, $title );
            }
        }
        return array( 'stateimpact', 'StateImpact' );
    }
    
	function widget( $args, $instance ) {        
    	extract( $args );
        $feed_url = get_option('network_feed_url', 'http://pipes.yahoo.com/pipes/pipe.run?_id=ead495cc3467b86874819c5faa72f01d&_render=rss');
    	$title = empty($instance['title']) ? "StateImpact Network News" : $instance['title'];
    	/* Before widget (defined by themes). */
            echo $before_widget;
            include_once( ABSPATH . WPINC . '/class-feed.php' );
            $feed = new SimplePie();
            $feed->set_cache_duration( 600 );
            $feed->set_cache_location( '/tmp' );
            // XXX: temporary
            $feed->set_feed_url( $feed_url );
            $feed->init();
            $feed->handle_content_type();
            
            ?>
            <div class="sw-network-news"> 
            <h3><?php echo $title ?></h3>
            <p class="swnn-tagline">Issues that matter. Close to home.</p>
            <ul> <?php
            foreach ( array_slice( $feed->get_items(), 0, 5 ) as $item ) {
                $encs = $item->get_enclosures();
                $thumbnail = '';
                if ($encs) {
                    foreach ( $encs as $enc ) {
                        if ( $enc->get_thumbnail() ) {
                            $thumbnail = $enc->get_thumbnail();
                            break;
                        }
                    }
                }

                $site_info  = $this->get_site_info( $item->get_permalink() );
                $hostname = "http://stateimpact.npr.org";
                $themedir = "statewatch";
                $state = $site_info[ 0 ];
                $site_name  = $site_info[ 1 ];

                // Use the touch icon as a backup thumbnail.
                if ( ! $thumbnail ) {
                    $thumbnail = sprintf( 'http://%s/wp-content/themes/%s/img/apple-touch-icon.png', $hostname, $theme_dir );
                }
    ?>

        <h6><?php echo $site_name; ?></h6>
        <h5><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h5>
        <!--
        <li class="clearfix">
            <a href="<?php echo $item->get_permalink(); ?>"><img src="<?php echo $thumbnail; ?>" alt="<?php echo $item->get_title(); ?>" width="60" height="60" /></a>
            <h5><a href="<?php echo $item->get_permalink(); ?>" title="<?php echo $item->get_title(); ?>"><?php echo $item->get_title(); ?></a> <span class="source-name">(<?php echo $site_name; ?>)</span></h5>
        </li>
        -->
    <?php
            }
    ?>
        </div>
    <?php /* After widget (defined by themes). */
    		echo $after_widget;
    
    }
    
}

?>