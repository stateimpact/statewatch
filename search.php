<?php
/**
 * Search results template
 */
?>

<?php get_header(); ?>

<div id="content" class="grid_8" role="main">

<?php
/*
 * Loop query string modifier to include our custom post types
 */
//global $wp_query;
//$args = array_merge( $wp_query->query, array( 'post_type' => sw_loop_post_types() ));
//query_posts( $args ); 
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>

            <?php 
                global $wp_query;
                $topics = sw_search_topics(get_search_query(), 5);
                $story_label = ($wp_query->found_posts === 1) ? "story" : "stories";
                $topics_label = ($topics->found_posts === 1) ? "topic" : "topics";
            ?>

        	<p class="search-term"><?php _e('Search results for ', 'argo');?>
        	    '<strong><?php the_search_query(); ?></strong>' </p>
            <?php do_action('before_search_results', get_search_query()); ?>
            
            <section class="topics">
            <h1>Topics</h1>
            <?php if ( $topics->post_count === 0 ) : ?>
                <article id="post-0" class="post error404 not-found">
                    <h3 class="entry-title">Not Found</h3>
                    <div class="entry-content">
                        <p>No topics matched your search request.</p>
                    </div><!-- .entry-content -->
                </article><!-- #post-0 -->
            <?php endif; ?>
            <?php while ( $topics->have_posts() ) : $topics->the_post(); ?>
                <article class="topic search-results clearfix">
                    <?php if (has_post_thumbnail($post->ID)): ?>
                        <?php echo get_the_post_thumbnail($post->ID, array(60, 60), array('class'=>'alignleft')); ?>
                    <?php endif ?>
                    <h2><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
            </section>
            
            <section class="posts">
            <h1>Stories</h1>
            <?php if ( !have_posts() ) : ?>
                <?php if ( ! is_tag() and ! is_category() ): ?>
                <article id="post-0" class="post error404 not-found">
                    <h3 class="entry-title">Not Found</h3>
                    <div class="entry-content">
                        <p>No stories matched your search request.</p>
                    </div><!-- .entry-content -->
                </article><!-- #post-0 -->
                <?php endif; ?>
            <?php endif; ?>
            <?php while (have_posts()) : the_post(); ?>
            <article class="search-results <?php echo $post->post_type; ?>">
                <header>
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( 'Permalink to %s', the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

                    <div class="post-meta top-meta">
                        <h6><?php argo_posted_on(); ?> | By  <?php the_author_posts_link(); ?> | <a href="<?php comments_link(); ?>"><?php comments_number('Leave a comment', 'One comment', '% comments'); ?></a></h6>
                        <ul class="labels">
                            <?php argo_the_post_labels( get_the_ID() ); ?>
                        </ul>
                    </div>
                    <!-- /.post-meta -->
                </header><!-- /result header -->
                        <?php the_excerpt(); ?>

            </article><!-- /.search-results -->
    	    <?php endwhile; ?>
            </section>
            <nav>
                <?php $links = paginate_links(array(
                    'base' => home_url('%_%') . '?s=' . urlencode(get_search_query()),
                    'total' => $wp_query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'format' => 'page/%#%/',
                    'end_size' => 2,
                )); ?>
                <p class="search-pagination"><?php echo $links; ?></p>
            </nav>
            <!-- /.search-pagination -->
                

</div><!--/ #content .grid_8-->

<aside id="sidebar" class="grid_4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->

<?php get_footer(); ?>
