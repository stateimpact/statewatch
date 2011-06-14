<?php
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'argo_load_static_widgets' );

/**
 * Register our widget.
 */
function argo_load_static_widgets() {
    register_widget( 'iog_abt_Widget' );
    register_widget( 'iog_network_news_Widget' );
    register_widget( 'iog_links_Widget' );
}

/**
 * about Widget class.
 */
class iog_abt_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function iog_abt_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'iog_abt', 'description' => __('Static placeholder', 'iog_abt') );

		/* Create the widget. */
		$this->WP_Widget( 'iog_abt', __('About Widget', 'about'), $widget_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget; ?>

<div class="sw-about"> 
<h3>About StateImpact New Hampshire</h3> 
 
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p> 
 
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p> 
 
<ul class="sw-social clearfix"> 
<li class="sw-twitter"><a href="#">Twitter</a></li> 
<li class="sw-fb"><a href="#">Facebook</a></li> 
<li class="sw-rss"><a href="#">RSS</a></li> 
</ul> 
 
<ul class="sw-info clearfix"> 
<li><a href="#">Learn more about StateImpact</a></li> 
<li><a href="#">Support StateImpact</a></li> 
</ul> 
 
<form role="search" method="get" action="http://statewatch.argoproject.org/florida"> 
	<div><label class="visuallyhidden" for="s1">Search for:</label> 
	<input type="text" placeholder="Search StateImpact <?php bloginfo('name'); ?>" value="" name="s" class="sw-about-search" /> 
	<input type="image" src="http://statewatch.argoproject.org/florida/wp-content/themes/argo-foundation/img/btn-go.png" alt="Submit" width="32" height="24" id="search-submit" /> 
	</div> 
</form> 

</div><!-- .sw-about -->


<?php		/* After widget (defined by themes). */
		echo $after_widget;
	}

}
/**
 * network news Widget class.
 */
class iog_network_news_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function iog_network_news_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'iog_network_news', 'description' => __('Static placeholder', 'iog_network_news') );

		/* Create the widget. */
		$this->WP_Widget( 'iog_network_news', __('Network News Widget', 'NN'), $widget_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget; ?>

<div class="sw-network-news"> 
<h3>StateImpact Network News</h3> 
<h6>StateImpact Florida</h6> 
<h4><a href="#">Lorem ipsum dolor sit amet</a></h4> 
<img src="http://statewatch.argoproject.org/florida/wp-content/themes/statewatch/img/dev-img/60x60.png"> 
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p> 
 
<h6>StateImpact Ohio</h6> 
<h5><a href="#">Lorem ipsum dolor sit amet</a></h5> 
 
<h6>StateImpact Idaho</h6> 
<h5><a href="#">Lorem ipsum dolor sit amet</a></h5> 
 
</div><!-- .sw-network-news -->

<?php		/* After widget (defined by themes). */
		echo $after_widget;
	}

}
/**
 * Beyond Statewatch Widget class.
 */
class iog_links_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function iog_links_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'iog_links', 'description' => __('Static placeholder', 'iog_links') );

		/* Create the widget. */
		$this->WP_Widget( 'iog_links', __('Beyond Widget', 'beyond'), $widget_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget; ?>

<div id="beyond-statewatch"> 
<h3>Beyond StateImpact</h3> 
<ul> 
<li> 
<h5><a href="#">A National Lab Develops Grid Controls to Handle Renewable Energy</a></h5> 
<p><img src="favicon.png" alt="favicon" width="16" height="16">NYTimes.com via bookmark (4 hours ago)</p> 
</li> 
 
<li> 
<h5><a href="#">A National Lab Develops Grid Controls to Handle Renewable Energy</a></h5> 
<p><img src="favicon.png" alt="favicon" width="16" height="16">NYTimes.com via bookmark (4 hours ago)</p> 
</li> 
 
<li> 
<h5><a href="#">A National Lab Develops Grid Controls to Handle Renewable Energy</a></h5> 
<p><img src="favicon.png" alt="favicon" width="16" height="16">NYTimes.com via bookmark (4 hours ago)</p> 
</li> 
 
<li> 
<h5><a href="#">A National Lab Develops Grid Controls to Handle Renewable Energy</a></h5> 
<p><img src="favicon.png" alt="favicon" width="16" height="16">NYTimes.com via bookmark (4 hours ago)</p> 
</li> 
 
<li> 
<h5><a href="#">A National Lab Develops Grid Controls to Handle Renewable Energy</a></h5> 
<p><img src="favicon.png" alt="favicon" width="16" height="16">NYTimes.com via bookmark (4 hours ago)</p> 
</li> 
 
</ul> 
</div><!-- #beyond-statewatch -->


<?php		/* After widget (defined by themes). */
		echo $after_widget;
	}

}
?>
