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
	    <h1><?php echo $topic->post_title; ?></h1>
		<ul class="meta-gestures">
			<li class="subscribe"><a href="<?php echo get_term_feed_link( $cat->term_id, $cat->taxonomy ); ?>">Follow this topic</a></li>
		    <li class="twitter"> 
		        <a href="<?php echo esc_url( 'http://twitter.com/share?url=' . $topic->guid . '&text=' ) . rawurlencode( $topic->post_title ); ?>" class="twitter-share-button" data-count="horizontal">Tweet</a>
		    </li>
            <li class="fb">
                <div id="fb-root"></div>
                <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-action="recommend"></div>
            </li>
		</ul>	
	<?php else: ?>
	    <h1><?php echo $cat->name; ?></h1>
		<ul class="meta-gestures">
			<li class="subscribe tag-subscribe"><a rel="alternate nofollow" href="<?php echo get_term_feed_link( $tag->term_id, $tag->taxonomy ); ?>">Follow this topic</a></li>
		</ul>
	<?php endif; ?>
		<div class="alltopics"><a href="<? echo get_permalink( $topics->ID ); ?>">View All Topics &raquo;</a></div>
	</div>

</div> <!-- /#coll-intro .grid_12 -->