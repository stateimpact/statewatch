<?php
/**
 * Page for displaying a single post.
 */
?>

<?php get_header(); ?>

    <article id="content" class="grid_8" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
<header>
<h1 class="entry-title"><?php the_title(); ?></h1>

	<div class="post-metadata clearfix">
		<div class="grid_3 alpha">
	        <h6 class="entry-date"><?php argo_posted_on(); ?> </h6>
			<h6>By <?php the_author_posts_link(); ?></h6>
		</div>
		<div class="grid_5 omega">
		<?php get_template_part( 'post', 'meta' ); ?>
		</div>
		<div class="clearfix"></div>
	</div> <!-- /.post-metadata-->

        <?php if (function_exists('the_subheading')) { the_subheading('<p>', '</p>'); } ?>
</header><!-- / entry header -->

        <?php the_content(); ?>


    </div> <!-- #post-## --> 

<?php if ( argo_has_categories_or_tags() ): ?>
<p class="tags">Filed under: <?php echo argo_the_categories_and_tags(); ?></p>
<?php endif; ?>    

<div class="post-author clearfix">
<?php echo get_avatar( get_the_author_meta( 'email' ), 60 ); ?>
<h4><?php the_author_posts_link(); ?></h4>
<h5><?the_author_meta( 'sw_title' ); ?></h5>
<p><?php the_author_meta( 'description' ); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">More...</a></p>
</div> <!-- /.post-author -->


<nav>
<ul class="post-nav clearfix">
<?php if ( get_next_post() ): ?>
<li class="n-post"><h5>Newer Post</h5><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link' ) . '</span>' ); ?></li>
<?php endif; ?>
<?php if ( get_previous_post() ): ?>
<li class="p-post"><h5>Older Post</h5><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link' ) . '</span> %title' ); ?></li>
<?php endif; ?>
</ul></nav><!-- .post-nav -->
  
<article>
    <a name="comments"></a>
    <?php comments_template( '', true ); ?>
</article><!-- / comments -->

<?php $rel_topics = argo_get_post_related_topics( 6 ); if ( $rel_topics ) { ?>
<div id="related-posts" class="idTabs clearfix">
    <ul id="related-post-nav">
        <li><h4>MORE POSTS ABOUT</h4></li>
        <?php foreach ( $rel_topics as $count => $topic ): ?>
        <li><a href="#rp<?php echo $count; ?>"><?php echo $topic->name; ?><span class="fold"></span></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="items">
        <?php foreach ( $rel_topics as $count => $topic ): ?>
        <div id="rp<?php echo $count; ?>">  
            <?php $rel_posts = argo_get_recent_posts_for_term( $topic, 3 ); ?>
            <ul>
                <?php $top_post = array_shift( $rel_posts ); ?>
                <li class="top-related clearfix">
                    <h3><a href="<?php echo get_permalink( $top_post->ID ); ?>" onClick="_gaq.push(['_trackEvent', 'RelatedPost', '<?php echo esc_attr($topic->name); ?>', '<?php echo esc_attr($top_post->post_title); ?>']);">
                    <?php echo $top_post->post_title; ?></a></h3>
                    
                    <?php if ( has_post_thumbnail( $top_post->ID ) ) { ?>
                        <img src="<?php echo argo_get_post_thumbnail_src( $top_post, '60x60' ); ?>" alt="related" width="60" height="60" />
                    <?php } ?>
                    <p><?php echo argo_get_excerpt( $top_post ); ?> <a href="<?php echo get_permalink( $top_post->ID ); ?>" onClick="_gaq.push(['_trackEvent', 'RelatedPost', '<?php echo esc_attr($topic->name); ?>', '<?php echo esc_attr($top_post->post_title); ?>']);"><b>Read More</b></a></p>
                </li>
                <?php foreach ( $rel_posts as $rel_post ): ?>
                    <li><a href="<?php echo get_permalink( $rel_post->ID ); ?>" onClick="_gaq.push(['_trackEvent', 'RelatedPost', '<?php echo esc_attr($topic->name); ?>', '<?php echo esc_attr($rel_post->post_title); ?>']);"><?php echo $rel_post->post_title; ?></a></li>
                <?php endforeach; ?>
            </ul>
                <p><a href="<?php echo get_term_link( $topic, $topic->taxonomy ); ?>" onClick="_gaq.push(['_trackEvent', 'RelatedPost', '<?php echo esc_attr($topic->name); ?>', 'archive page']);"><strong>View all <?php echo $topic->name; ?> posts &raquo;</strong></a></p>
        </div> <!-- /#rpX -->
        <?php endforeach; ?>
    </div> <!-- /.items -->
</div> <!-- /#related-posts -->
<?php } // if ( $rel_posts ) ?>

<?php endwhile; // end of the loop. ?>

</article><!-- / #content .grid8 -->

<aside id="sidebar" class="grid_4">
    <?php get_sidebar('post'); ?>
</aside> <!-- /.grid_4 -->

<?php get_template_part( 'featured-topics' ); ?>

<?php get_footer(); ?>
