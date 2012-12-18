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
// This is inefficient and should be fixed at some point.
// Plugins that add custom post types should inject those types
// into the loop without relying on the theme. See JiffyPosts.
global $wp_query;
$args = array_merge( $wp_query->query, array( 'post_type' => sw_loop_post_types() ));
query_posts( $args ); 
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
    <article id="post-<?php the_ID(); ?>" <?php post_class('grid_8 alpha post-content'); ?>>
    <?php if ( is_front_page() && is_sticky() ):  ?>
        <div class="sticky-solo clearfix">
            <h5>Featured</h5> 
            <?php if ( has_post_thumbnail() ): ?>
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
            <?php endif; ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
            <p><?php navis_the_raw_excerpt(); // the_excerpt(); ?> <br><a href="<?php the_permalink(); ?>">Continue reading <span class="meta-nav">&rarr;</span></a></p> 
        </div>

    <?php elseif (sw_is_rich_media()): ?>
        <div class="sticky-solo clearfix">
            <ul class="labels">
                <?php argo_the_post_labels( get_the_ID() ); ?>
            </ul>
        
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 

            <div class="post-metadata ">

                    <h6 class="entry-date"><a href="<?php the_permalink(); ?>"><?php argo_posted_on(); ?></a></h6>
                    <h6>By <?php
                    if (function_exists('coauthors_posts_links')):
                        coauthors_posts_links();
                    else:
                        the_author_posts_link();
                    endif; ?>
                    </h6>
                <div class="clearfix"></div>
            </div> <!-- /.post-metadata-->
            <?php if ( has_post_thumbnail() ): ?>
            <a class="alignright" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
        <?php endif; ?>
            <p><?php navis_the_raw_excerpt(100); // the_excerpt(); ?> <a href="<?php the_permalink(); ?>">Continue reading <span class="meta-nav">&rarr;</span></a></p> 
        </div>

    <?php else: ?>
    <header>


        <h2 class="entry-title"><a href="<?php sw_headline_link(); ?>"><?php the_title(); ?></a></h2>

        <ul class="labels">
            <?php argo_the_post_labels( get_the_ID() ); ?>
        </ul>
    	<div class="post-metadata grid_8 alpha omega">

    	        <h6 class="entry-date"><a href="<?php the_permalink(); ?>"><?php argo_posted_on(); ?></a></h6>
                <?php if (get_post_type($post->ID) != 'jiffypost'): ?>
    			<h6>By <?php
    			if (function_exists('coauthors_posts_links')):
                    coauthors_posts_links();
                else:
                    the_author_posts_link();
                endif; ?>
    			</h6>
                <?php endif; ?>
    		<div class="clearfix"></div>
    	</div> <!-- /.post-metadata-->
        <div class="clearfix"></div>    
    </header><!-- / entry header -->

        <?php if ( is_archive() ) :  ?>

                <?php the_content( 'Continue Reading <span class="meta-nav">&rarr;</span>' ); ?>
    	    <?php wp_link_pages( array( 'before' => '<div class="page-link">Pages:', 'after' => '</div>' ) ); ?>
    	
        <?php else : ?>
                <?php the_content( 'Continue Reading <span class="meta-nav">&rarr;</span>' ); ?>

                <?php wp_link_pages( array( 'before' => '<div class="page-link">Pages:', 'after' => '</div>' ) ); ?>

        <?php endif; ?>
    <?php endif; // is_sticky() ?>
    <!--  ############## removed .entry-utility ######### -->
    </article><!-- #post-## -->
    <?php comments_template( '', true ); ?>
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
<?php endif; // check for pagination ?>