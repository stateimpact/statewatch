<?php
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'argo_load_static_widgets' );

/**
 * Register our widget.
 */
function argo_load_static_widgets() {
    register_widget( 'crowd_Widget' );
    register_widget( 'discussions_Widget' );
    register_widget( 'must_Widget' );
    register_widget( 'flick_Widget' );
}

/**
 * crowd Widget class.
 */
class crowd_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function crowd_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'crowd', 'description' => __('Static placeholder', 'crowd') );

		/* Create the widget. */
		$this->WP_Widget( 'crowd-widget', __('crowd Widget', 'crowd'), $widget_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget; ?>

<h3>CROWD PICKS</h3>
<div class="current-call clearfix">

<img src="<?php bloginfo('template_directory'); ?>/img/dev-images/hand.jpg" alt="140x140" width="140" height="140" />

<h4><a href="#" title="note">Which organizations do you give to?</a></h4>
<p>From what we know of our crowd, you're a pretty compassionate bunch. So who do you give your money to? <a href="#" title="vote now">VOTE NOW</a></p>

</div>
<!-- /.current-call -->
<h5>PREVIOUS CROWD PICKS</h5>
<ul>
<li><a href="#" title="headline">Who's history's greatest global health visionary? </a></li>
<li><a href="#" title="headline">Which medical innovations are you most excited for?</a></li>
<li><a href="#" title="headline">Best global pandemic films?</a></li>
</ul>


<?php		/* After widget (defined by themes). */
		echo $after_widget;
	}

}
/**
 * discussions Widget class.
 */
class discussions_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function discussions_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'discussions', 'description' => __('Static placeholder', 'discussions') );

		/* Create the widget. */
		$this->WP_Widget( 'discussions-widget', __('discussions Widget', 'discussions'), $widget_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget; ?>

<h3>MOST COMMENTED</h3>

<ul>
<li class="clearfix">
<strong  class="comment-count level3">
<span>1,161</span> comments
</strong>
<a href="#" title="headline">
Partying for prevention
</a>
</li>

<li class="clearfix">
<strong  class="comment-count level2">
<span>500</span> comments
</strong>
<a href="#" title="headline">
The 5 biggest global health controversies
</a>
</li>

<li class="clearfix">
<strong  class="comment-count level1">
<span>250</span> comments
</strong>
<a href="#" title="headline">
Empowering women to stop rape in the Congo
</a>
</li>
</ul>

<?php		/* After widget (defined by themes). */
		echo $after_widget;
	}

}
/**
 * must Widget class.
 */
class must_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function must_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'must', 'description' => __('Static placeholder', 'must') );

		/* Create the widget. */
		$this->WP_Widget( 'must-widget', __('must Widget', 'must'), $widget_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget;?>

<h3>MUST READS</h3>
<ul>
<li><img src="<?php bloginfo('template_directory'); ?>/img/dev-images/must-reads.jpg" alt="60x60a" width="60" height="60" />
<h4><a href="#" title="headline">The top 20 global health priorities</a></h4>
<h6>Time</h6>
<p>In one of the world's largest public-health collaborations, 155 experts from 50 countries have a plan to tackle the world's deadliest diseases.</p>
</li>

<li>
<h5><a href="#" title="headline">The 5 biggest global health controversies</a></h5>
<h6>Change.org</h6>
</li>

<li>
<h5><a href="#" title="headline">The US Global Health Initiative: Key issues</a></h5>
<h6>Kaiser Health News</h6>
</li>
</ul>

<?php /* After widget (defined by themes). */
		echo $after_widget;
	}

}
/**
 * flick Widget class.
 */
class flick_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function flick_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'flick', 'description' => __('Static placeholder', 'flick') );

		/* Create the widget. */
		$this->WP_Widget( 'flick-widget', __('flick Widget', 'flick'), $widget_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget;?>

<h3>VITAL SIGNS PHOTOS</h3>
<p><strong>ADD YOURS.</strong> Tag your photos #tagname on Flickr.</p>

<div class="flickr-badge clearfix">
<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=8&display=latest&size=s&layout=h&source=user_set&user=26008544%40N00&set=72157594235451142&context=in%2Fset-72157594235451142%2F"></script>
</div>
<!-- /Flickr Badge -->
<p><a href="#" title="view all">VIEW ALL PHOTOS FOR THIS TOPIC</a></p>

<?php /* After widget (defined by themes). */
		echo $after_widget;
	}

}
?>
