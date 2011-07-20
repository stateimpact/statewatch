<?php
/**
 * The template for displaying content type archives
 */

$term = $wp_query->get_queried_object();
?>

<?php  get_header();
/* $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); */
?>




<div id="content" class="grid_8" role="main">
	<?php if ($term->name):?>
	<h1><?php echo $term->name; ?></h1>
	<?php endif; ?>
<?php
/* Run the loop for the category page to output the posts.
* If you want to overload this in a child theme then include a file
* called loop-category.php and that will be used instead.
*/
get_template_part( 'loop', 'category' ); ?>
</div>
<!-- /.grid_8 #content -->

<aside id="sidebar" class="grid_4">
<?php get_sidebar('category'); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
