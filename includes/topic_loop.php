<?php
/***
Loop documentation
http://codex.wordpress.org/The_Loop to understand it and
http://codex.wordpress.org/Template_Tags to understand
***/
?>
<?php 
/*
 * Loop query string modifier to include our custom post types
 */
query_posts( argo_post_types_qs() ); 
?>
<?php
	/* Start the Loop.
	 *
	 * We sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>

<?php while (have_posts()) : the_post(); ?>
<?php if(is_new_day()): ?>
<div class="day storywrapper">
    <?php the_date('F j, Y', '<h6 class="entry-date grid_2 alpha">', '</h2>'); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('grid_6 omega post-content'); ?>>
<?php else: ?>
<div class="storywrapper">
    <article id="post-<?php the_ID(); ?>" <?php post_class('grid_6 prefix_2 alpha omega headerrule post-content'); ?>>
<?php endif; ?>

            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
            <?php if ( has_post_thumbnail() ): ?>
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            <?php endif; ?>
            <p><?php the_excerpt(); ?></p> 
    </article><!-- #post-## -->
    <?php comments_template( '', true ); ?>
</div><!-- .storywrapper -->
<?php endwhile; // End the loop. Whew. ?>
<?php $next = get_next_post(); $previous = get_previous_post(); ?>
<?php if ( $next || $previous ) :  ?>
<div class="grid_8 alpha">
	<nav>
		<ul class="list-pagination">
		    <?php if ($next): ?>
		    <li class="older-posts"><?php next_posts_link( '&laquo; Older posts', $wp_query->max_num_pages ); ?></li>
		    <?php endif; ?><?php if ($previous): ?>
		    <li class="newer-posts"><?php previous_posts_link( 'Newer posts &raquo;', $wp_query->max_num_pages ); ?></li>
		    <?php endif; ?>
		</ul>
	</nav><!-- .list-pagination -->
</div> <!-- .grid_8 alpha -->
<div class="clearfix"></div>
<?php endif; // check for pagination ?>