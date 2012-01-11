<?php
/*
Template Name: Topic index
*/
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

<nav class="alpha-nav clearfix">
    <ul>
        <li><a href="#a">A</a></li>
        <li><a href="#b">B</a></li>
        <li><a href="#c">C</a></li>
        <li><a href="#d">D</a></li>
        <li><a href="#e">E</a></li>
        <li><a href="#f">F</a></li>
        <li><a href="#g">G</a></li>
        <li><a href="#h">H</a></li>
        <li><a href="#i">I</a></li>
        <li><a href="#j">J</a></li>
        <li><a href="#k">K</a></li>
        <li><a href="#l">L</a></li>
        <li><a href="#m">M</a></li>
        <li><a href="#n">N</a></li>
        <li><a href="#o">O</a></li>
        <li><a href="#p">P</a></li>
        <li><a href="#q">Q</a></li>
        <li><a href="#r">R</a></li>
        <li><a href="#s">S</a></li>
        <li><a href="#t">T</a></li>
        <li><a href="#u">U</a></li>
        <li><a href="#v">V</a></li>
        <li><a href="#w">W</a></li>
        <li><a href="#x">X</a></li>
        <li><a href="#y">Y</a></li>
        <li><a href="#z">Z</a></li>
    </ul>
</nav>
<!-- /.alpha-nav -->

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
	
	<div class="number abc_tags">
		<ul>
	<?php
	foreach($post_tags as $key => $tag) {
		$newletter = substr($tag->slug, 0, 1);
		if($newletter !== $letter/* && $key != 0*/) { ?>
		</ul>
		<p><a href="#content">Back to top  &uarr;</a></p>
	</div>
	
	<div class="<?php echo strtolower($newletter); ?> abc_tags clearfix">
	
	<div class="tag-letter">
	<h3 id="<?php echo strtolower($newletter); ?>"><?php echo strtolower($newletter); ?></h3>
	
	</div>
	
		<ul>
	<?php	} $letter = substr($tag->slug, 0, 1); ?>
			<li><a href="<?php echo get_tag_link($tag->term_id); ?>" title="<?php echo sprintf( __( "View all posts in %s" ), $tag->name ); ?>"><?php echo $tag->name.' <span class="count">'.$tag->count.'</span>';?></a></li>
			
		<?php
	}
		?>
		
		</ul>
		
	</div>
	<!--/.letter-->

</article>
<!--/.grid_8-->

<aside id="sidebar" class="grid_4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
