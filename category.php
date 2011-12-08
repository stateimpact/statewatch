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
<div id="crp"><h6>Recent Posts</h6></div> 
<?php 
/* Run the loop for the category page to output the posts.
* If you want to overload this in a child theme then include a file
* called loop-category.php and that will be used instead.
*/
get_template_part( 'includes/topic_loop', 'category' ); ?>
</div>
<!-- /.grid_8 #content -->


<aside id="sidebar" class="grid_4">
	<?php get_template_part( 'includes/collection-links' ); ?>
	<?php get_sidebar('category'); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
