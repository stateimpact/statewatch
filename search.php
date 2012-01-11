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
//query_posts( argo_post_types_qs() );
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
    <?php if ( ! is_tag() and ! is_category() ): ?>
    <article id="post-0" class="post error404 not-found">
        <h3 class="entry-title">Not Found</h3>
        <div class="entry-content">
            <p>We're sorry. No posts matched your search request.</p>
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->
    <?php endif; ?>
<?php endif; ?>

        <?php if (have_posts()) : ?>

        	<p class="search-term"><?php _e('Your Search for', 'argo');?>
        	    '<strong><?php the_search_query(); ?></strong>' 
        	    <?php _e('returned', 'argo');?> 
        	    <strong><?php echo $wp_query->found_posts; ?> 
        	    <?php _e('results', 'argo');?></strong>
        	</p>
            <?php do_action('before_search_results', get_search_query()); ?>
            
            <?php $topics = sw_search_topics(get_search_query(), 5); ?>
            <?php foreach ($topics->posts as $i => $topic): ?>
                <article class="topic search-results clearfix">
                    <?php if (has_post_thumbnail($topic->ID)): ?>
                        <?php echo get_the_post_thumbnail($topic->ID, array(60, 60), array('class'=>'alignleft')); ?>
                    <?php endif ?>
                    <h2><a href="<?php echo get_permalink($topic->ID); ?>"><?php echo get_the_title($topic->ID); ?></a></h2>
                    <?php echo apply_filters('the_excerpt', get_the_excerpt($topic->ID)); ?>
                </article>
            <?php endforeach ?>
            
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
            <nav>
                <p class="search-pagination"><?php argo_pagination() ?></p>
            </nav>
            <!-- /.search-pagination -->
                
		<?php endif; ?>

</div><!--/ #content .grid_8-->

<aside id="sidebar" class="grid_4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->

<?php get_footer(); ?>
