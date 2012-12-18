<?php
/**
 * Page for displaying a single post.
 */
?>
<?php get_header(); ?>

    <article id="content" class="grid_8" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('clearfix post-content'); ?>>
<header>
<?php if (get_post_type($post) == 'jiffypost'): ?>
    <h1 class="entry-title"><a href="<?php sw_headline_link(); ?>"><?php the_title(); ?></a></h1>
<?php else: ?>
    <h1 class="entry-title"><?php the_title(); ?></h1>
<?php endif; ?>
    <ul class="labels">
        <?php argo_the_post_labels( get_the_ID() ); ?>
    </ul>

	<div class="post-metadata clearfix">
		<div class="grid_3 alpha">
	        <h6 class="entry-date"><?php argo_posted_on(); ?> </h6>
            <?php if (get_post_type($post) != 'jiffypost'): ?>
			<h6>By 
			<?php
			if (function_exists('coauthors_posts_links')):
                coauthors_posts_links();
            else:
                the_author_posts_link();
            endif; ?>
            </h6>
            <?php endif; ?>
		</div>
        <?php if (get_post_type($post) != 'jiffypost'): ?>
		<div class="grid_5 omega">
		<?php get_template_part( 'post', 'meta' ); ?>
		</div>
        <?php endif; ?>
		<div class="clearfix"></div>
	</div> <!-- /.post-metadata-->
	<div class="clearfix"></div>
        <?php if (function_exists('the_subheading')) { the_subheading('<p>', '</p>'); } ?>
</header><!-- / entry header -->

        <?php the_content(); ?>


    </div> <!-- #post-## --> 
    
<?php do_action('after_the_content'); ?>

<?php if (!get_post_type($post) == 'jiffypost'): ?>
<article id="comments" class="article-comments clearfix">
    <h2 id="respond">Comments</h2>
    <?php comments_template( '', true ); ?>
</article><!-- / comments -->
<?php endif; ?>

<nav>
<ul class="post-nav clearfix">
<?php if ( get_next_post() ): ?>
<li class="n-post"><h5>Next Post</h5><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link' ) . '</span>' ); ?></li>
<?php endif; ?>
<?php if ( get_previous_post() ): ?>
<li class="p-post"><h5>Previous Post</h5><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link' ) . '</span> %title' ); ?></li>
<?php endif; ?>
</ul></nav><!-- .post-nav -->


<?php endwhile; // end of the loop. ?>

</article><!-- / #content .grid8 -->

<aside id="sidebar" class="grid_4">
    <?php get_sidebar('post'); ?>
</aside> <!-- /.grid_4 -->

<?php get_footer(); ?>

