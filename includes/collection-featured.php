<?php
$tag = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $tag );
$featured = sw_get_topic_featured_posts( $topic->ID );
?>

<?php if ($featured): ?>
    <div class="topic-featured">
    	<h2 class="section-hed">Key Stories</h2>
        <?php foreach($featured as $post): ?>
    	<div class="story">
    		<h4 class="pub-date"><?php the_date('F j, Y'); ?></h4>
    		<?php if (has_post_thumbnail()): ?>
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail', array('class'=>'alignleft')); ?></a>
    		<?php endif; ?>
    		<h3 class="headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    	</div>
        <?php endforeach; ?>
    </div>
    <div class="clearfix"></div>
<?php endif; ?>