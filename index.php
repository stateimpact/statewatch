<?php
/**
 * The main template file and home page.
 */
?>
 
<?php get_header(); ?>
<?php get_template_part( 'featured-topics' ); ?>

<div id="content" class="grid_8" role="main">

			<?php
			/* Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			 get_template_part( 'loop', 'index' );
			?>

</div><!--/.grid_8 #content-->

<aside id="sidebar" class="grid_4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->

<?php get_footer(); ?>
