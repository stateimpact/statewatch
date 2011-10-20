<?php
/***
* Template Name Posts: Full Width
***/
?>

<?php get_header(); ?>

    <article id="content" role="main">
<div class="widepost grid_12">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('clearfix post-content'); ?>>
<header>
<h1 class="entry-title"><?php the_title(); ?></h1>

	<div class="post-metadata clearfix">
		<div class="grid_3 alpha">
	        <h6 class="entry-date"><?php argo_posted_on(); ?> </h6>
			<h6>By 
			<?php
			if (function_exists('coauthors_posts_links')):
                coauthors_posts_links();
            else:
                the_author_posts_link();
            endif; ?>
            </h6>
		</div>
		<div class="grid_5 omega">
		<?php get_template_part( 'post', 'meta' ); ?>
		</div>
		<div class="clearfix"></div>
	</div> <!-- /.post-metadata-->
	<div class="clearfix"></div>
        <?php if (function_exists('the_subheading')) { the_subheading('<p>', '</p>'); } ?>
</header><!-- / entry header -->

        <?php the_content(); ?>


    </div> <!-- #post-## --> 
</div>
<div class="grid_8">

<?php do_action('after_the_content'); ?>
  
<article id="comments" class="article-comments clearfix">
    <h2 id="respond">Comments</h2>
    <?php comments_template( '', true ); ?>
</article><!-- / comments -->


</div>
<?php endwhile; // end of the loop. ?>

<aside id="sidebar" class="grid_4">
    <?php get_sidebar('post'); ?>
</aside> <!-- /.grid_4 -->
</article><!-- / #content .grid12 -->


<?php get_footer(); ?>
