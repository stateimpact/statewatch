<?php
$topics = get_static_page('topic-index');
$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
// $links = sw_get_topic_featured_links( $topic );
// $first_link = $links[0];
?>
<div class="topic-hed grid_12"> 
		<h2 class="section-hed"><a href="<? echo get_permalink( $topics->ID ); ?>">Topics</a></h2>
	<?php if ($topic->post_title): ?>
		<?php echo get_the_post_thumbnail( $topic->ID, array(140, 140)); ?>
	    <h1><?php echo $topic->post_title; ?></h1>
	<?php else: ?>
	    <h1><?php echo $cat->name; ?></h1>
	<?php endif; ?>
		<div class="alltopics"><a href="<?php echo get_permalink( $topics->ID ); ?>">View All Topics &raquo;</a></div>
</div> <!-- /#coll-intro .grid_12 -->
