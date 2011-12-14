<?php
$tag = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $tag );
$multimedia = sw_get_topic_multimedia($topic->ID);
?>
<?php if ($multimedia->have_posts()): ?>
<div class="topic-multimedia">
	<h2 class="section-hed">Multimedia</h2>
    <?php while ($multimedia->have_posts()): $multimedia->the_post(); ?>
	<?php if (has_post_thumbnail()): ?>
	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(array(300, 100)); ?></a>
	<?php endif; ?>
	<h4 class="headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    <?php endwhile; ?>
</div>
<?php endif; ?>