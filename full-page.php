<?php
/*
Template Name: Full Width Page
 */
?>

<?php get_header(); ?>

<div id="content" role="main">

<div class="grid_12">		
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h2 class="entry-title"><?php the_title(); ?></h2>		
<?php the_content(); ?>						
</div><!-- #post-## -->
</div><!--/.grid_12-->

<div class="grid_8">
<?php comments_template( '', true ); ?>
<?php endwhile; ?>
</div><!-- .grid_8 -->

</div><!-- #content -->

<div id="sidebar" class="grid_4">
<?php get_sidebar('slideshow'); ?>
</div><!-- /.grid_4 -->
<?php get_footer(); ?>
