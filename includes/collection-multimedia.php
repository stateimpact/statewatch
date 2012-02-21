<?php
$tag = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $tag );
$multimedia = sw_get_topic_multimedia($topic->ID);
?>
<?php if ($multimedia->have_posts()): ?>
<div class="topic-multimedia">
	<h2 class="section-hed">Multimedia</h2>
    <?php while ($multimedia->have_posts()): $multimedia->the_post(); ?>
    <?php $content_types = wp_get_object_terms($post->ID, 'feature'); ?>
	<?php if (has_post_thumbnail()): ?>
	<a href="<?php echo get_post_meta($post->ID, 'multimedia_url', true); ?>"><?php the_post_thumbnail('multimedia-thumb'); ?></a>
	<?php endif; ?>
	<h4 class="headline">
	    <a href="<?php echo get_post_meta($post->ID, 'multimedia_url', true); ?>">
	    <?php if ($content_types): ?>
	        <strong><?php echo $content_types[0]->name; ?>: </strong>
	    <?php endif; ?>
	        <?php the_title(); ?>
	    </a>
	</h4>
    <?php endwhile; ?>
</div>
<?php endif; ?>