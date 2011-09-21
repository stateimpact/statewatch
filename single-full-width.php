<?php
/***
* Template Name Posts: Full Width
***/
?>

<?php get_header(); ?>

    <article id="content" role="main">
<div class="widepost grid_12">
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
	<div class="clearfix"></div>
        <?php if (function_exists('the_subheading')) { the_subheading('<p>', '</p>'); } ?>
</header><!-- / entry header -->

        <?php the_content(); ?>


    </div> <!-- #post-## --> 

<?php if ( argo_has_categories_or_tags() ): ?>
<p class="tags">Filed under: <?php echo argo_the_categories_and_tags(); ?></p>
<?php endif; ?>
</div>
<div class="grid_8">

  
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
                <p><a href="<?php echo get_term_link( $topic, $topic->taxonomy ); ?>" onClick="_gaq.push(['_trackEvent', 'RelatedPost', '<?php echo esc_attr($topic->name); ?>', 'archive page']);"><strong>View All <?php echo $topic->name; ?> Posts &raquo;</strong></a></p>
        </div> <!-- /#rpX -->
        <?php endforeach; ?>
    </div> <!-- /.items -->
</div> <!-- /#related-posts -->
<?php } // if ( $rel_posts ) ?>
</div>
<?php endwhile; // end of the loop. ?>

<aside id="sidebar" class="grid_4">
    <?php get_sidebar('post'); ?>
</aside> <!-- /.grid_4 -->
</article><!-- / #content .grid12 -->

<?php get_template_part( 'featured-topics' ); ?>

<?php get_footer(); ?>
