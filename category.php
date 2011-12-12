<?php
/**
 * The template for displaying Category Archive pages.
 */

$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
?>

<?php get_header(); ?>
<?php get_template_part( 'includes/collection-header' ); ?>

<div id="content" class="grid_8" role="main">
<?php get_template_part( 'includes/collection-background' ); ?>	
<div class="topic-posts">
	<h2 class="section-hed">Recent Posts</h2>
		<ul class="meta-gestures">
			<li class="subscribe"><a href="<?php echo get_term_feed_link( $cat->term_id, $cat->taxonomy ); ?>">Follow this topic</a></li>
		</ul>	

<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'includes/topic_loop', 'tag' );
?>
</div> 
</div>
<!-- /.grid_8 #content -->
			
<aside id="sidebar" class="grid_4">
	<?php get_template_part( 'includes/collection-links' ); ?>
    <?php get_sidebar('topic'); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
