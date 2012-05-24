<?php
/*
Template Name: Topic index
*/
?>

<?php
function sw_topic_filtering() {
        $js = get_bloginfo('stylesheet_directory') . "/js/topic-filtering.js";
        wp_enqueue_script('topicfilter', $js);
}    
add_action('wp_enqueue_scripts', 'sw_topic_filtering');
?>

<?php get_header(); ?>

<article class="grid_8">

<div id="content">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if ( is_front_page() ) { ?>
            <h2 class="entry-title"><?php the_title(); ?></h2>
        <?php } else { ?>	
            <h2 class="entry-title"><?php the_title(); ?></h2>
        <?php } ?>				

        <div class="entry-content">
            <?php the_content(); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-link">Pages:', 'after' => '</div>' ) ); ?>
        </div><!-- .entry-content -->
    </div><!-- #post-## -->
<?php endwhile; ?>

</div><!-- #content -->

    <form method="get" autocomplete="off">
        <div>
            <input type="text" value="" name="q" id="term" placeholder="Search all topics" />
        </div> 
    </form>
<?php
    $query_string = '
		SELECT *,name FROM '.$wpdb->prefix.'term_taxonomy
		JOIN '.$wpdb->prefix.'terms
		ON '.$wpdb->prefix.'term_taxonomy.term_id = '.$wpdb->prefix.'terms.term_id
		WHERE '.$wpdb->prefix.'term_taxonomy.taxonomy = "post_tag"
		ORDER by  '.$wpdb->prefix.'terms.slug ASC
    ';
	$post_tags = $wpdb->get_results($query_string);
	?>
	
	<div class="">
		<table id="tags" class="abc_tags">
            <thead>
                <tr>
                    <th>Topic</th>
                    <th class="count">Posts</th>
                </tr>
            </thead>
            <tbody>
	<?php
	foreach($post_tags as $key => $tag) {
    ?>
			<tr>
                <td><a href="<?php echo get_tag_link($tag->term_id); ?>" title="<?php echo sprintf( __( "View all posts in %s" ), $tag->name ); ?>"><?php echo $tag->name.' </a>';?></td>
                <td class="count"><?php echo $tag->count;?></td>
            </tr>
	<?php }	?>
		    </tbody>
		</table>
		
	</div>
	<!--/.letter-->

</article>
<!--/.grid_8-->

<aside id="sidebar" class="grid_4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->

<?php get_footer(); ?>
