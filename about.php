<?php
/**
 * Template Name: About
 */
?>

<?php get_header(); ?>

<article id="content" class="grid_8" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="grid_4 alpha">

<div class="sw-about">
<h3>About StateWatch Florida</h3>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

<ul class="sw-social clearfix">
<li class="sw-twitter"><a href="#">Twitter</a></li>
<li class="sw-fb"><a href="#">Facebook</a></li>
<li class="sw-rss"><a href="#">RSS</a></li>
</ul>

</div><!-- .sw-about -->

</div><!-- / .grid_4 alpha -->

<div class="grid_4 omega">
<img src="http://argoproject.org/prototypes/statewatch/pantry/img/florida.png" alt="florida" width="300" height="233" />
</div><!-- / .grid_4 omega -->

<div class="grid_4 alpha">

<h3>Staff</h3>

<div class="abt-staff clearfix">
<img src="http://argoproject.org/prototypes/statewatch/pantry/img/60x60.png" alt="60x60" width="60" height="60" />
<h4><a href="#">Reporter Name</a></h4>
<h5>Reporter Title</h5>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
</div><!-- /.abt-staff -->

<div class="abt-staff clearfix">
<img src="http://argoproject.org/prototypes/statewatch/pantry/img/60x60.png" alt="60x60" width="60" height="60" />
<h4><a href="#">Reporter Name</a></h4>
<h5>Reporter Title</h5>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
</div><!-- /.abt-staff -->

<h3>Partner Stations</h3>

<dl class="partner-station">
<dt><a href="#">WAMU</a></dt>
<dd class="station-logo"><img src="http://argoproject.org/prototypes/statewatch/pantry/img/wamu100.png" alt="wamu100" width="100" height="50" /></dd>
<dd>Washington <b>88.5</b></dd>
<dd><a href="#">Support</a></dd>
</dl>

</div><!-- / .grid_4 alpha -->

<div class="grid_4 omega">

<div id="sw-abt-network">
<h3>About the network</h3>

<h4>Issues that matter. Close to Home</h4>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
</div> <!-- /#sw-abt-network -->

<div id="sw-network-partners">
<h4>Network Partners</h4>
<ul>
<li><a href="#">Florida</a> <b>Education</b></li>
<li><a href="#">Idaho</a> <b>Economy</b></li>
<li><a href="#">Ohio</a> <b>Education</b></li>
</ul>
</div> <!-- /#sw-network-partners -->

<div id="sw-abt-npr">
<h4>About NPR</h4>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>

<ul>
<li><a href="#">Station Finder</a></li>
</ul>
</div> <!-- /#sw-abt-npr -->

<div id="sw-sponsors">
<h4>Sponsors</h4>

<h5><a href="#">Sponsor Name</a></h5>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
</div> <!-- /#sw-sponsors -->

</div><!-- / .grid_4 omega -->
					
</div><!-- #post-## -->


<?php endwhile; ?>

</article><!-- / #content .grid8 -->

<aside id="sidebar" class="grid_4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
