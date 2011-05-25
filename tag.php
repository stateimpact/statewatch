<?php
/**
 * The template for displaying Tag Archive pages.
 */

$tag = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $tag );
?>

<?php get_header(); ?>
<div id="coll-intro" class="grid_12 coll-dl"> 
<h2><?php single_tag_title(); ?></h2> 

<div class="coll-desc clearfix"> 
<h6>Background</h6>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p> 

<p>Ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed.</p>
</div>

<div class="coll-links">
<h6>Key Links</h6>
<ul>
<li><a href="#">Fracking with our food: how gas drilling affects farming</a> <span class="key-source">(Miami Herald)</span></li>
<li><a href="#">Susquehanna River named most endangered in US due to fracking</a> <span class="key-source">(The Tennessean)</span></li>
<li><a href="#">Fracking As A Fractured Relationship With Ourselves</a> <span class="key-source">(Treehugger)</span></li>
<li><a href="#">Safety first on fracking</a> <span class="key-source">(Philadelphia Inquirer)</span></li>
<li><a href="#">Dot Earth: New Tool, and Tune, for Tracking Fracking</a> <span class="key-source">(New York Times (blog))</span></li>
</ul>
</div>
</div> <!-- DESCRIPTION AND LINKS /#coll-intro .grid_12 --> 

<div id="content" class="grid_8" role="main">
<div id="crp"><h6>Recent</h6></div> 
<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'tag' );
?>
</div>
<!-- /.grid_8 #content -->
			
<aside id="sidebar" class="grid_4">
    <?php get_sidebar('topic'); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
