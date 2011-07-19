<?php
$topics = get_static_page('topic-index');
$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
$links = sw_get_topic_featured_links( $topic );
$first_link = $links[0];
?>
<div id="coll-intro" class="grid_12"> 
	<div class="coll-header">
		<h5><a href="<? echo get_permalink( $topics->ID ); ?>">Topics</a></h5>
	<?php if ($topic->post_title): ?>
	    <h2><?php echo $topic->post_title; ?></h2>
		<ul class="meta-gestures">
		    <li class="twitter"> 
		        <a href="<?php echo esc_url( 'http://twitter.com/share?url=' . get_permalink() . '&text=' ) . argo_get_twitter_title(); ?>" class="twitter-share-button" data-count="horizontal">Tweet</a>
		    </li>
		    <li class="fb">
		        <a name="fb_share" share_url="<?php the_permalink(); ?>" type="button_count" href="<?php echo esc_url( 'http://www.facebook.com/sharer.php?u=' . get_permalink() . '&t=' ) . get_the_title();  ?>">Share</a>
		    </li>
		</ul>
	<?php else: ?>
	    <h2><?php echo $cat->name; ?></h2>
	<?php endif; ?>
		<div class="alltopics"><a href="<? echo get_permalink( $topics->ID ); ?>">View All Topics &raquo;</a></div>
	</div>

</div> <!-- /#coll-intro .grid_12 -->