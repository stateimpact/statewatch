<?php
/**
 * Template Name: About
 */
?>

<?php get_header(); ?>

<article id="content" class="grid_8" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="grid_8 alpha">

<div class="sw-about">
<h3><?php the_title(); ?> <?php bloginfo('name'); ?></h3>

<div class="content"><?php the_content(); ?></div>

    <ul class="sw-social clearfix">
    <?php if ( get_option( 'twitter_link' ) ): ?>
        <li class="sw-twitter"><a href="<?php echo get_option( 'twitter_link' ); ?>">Twitter</a></li>
    <?php endif; ?>
    <?php if ( get_option( 'facebook_link' ) ): ?>
        <li class="sw-fb"><a href="<?php echo get_option( 'facebook_link' ); ?>">Facebook</a></li>
    <?php endif; ?>
        <li class="sw-rss"><?php echo the_feed_link( 'RSS' ); ?></li>
    </ul>

</div><!-- .sw-about -->

<img src="http://argoproject.org/prototypes/statewatch/pantry/img/florida.png" alt="florida" width="300" height="233" />

</div><!-- / .grid_8 alpha -->



<div class="grid_4 alpha">

<h3>Staff</h3>
<?php $staff = get_staff(); ?>
<?php foreach ( $staff as $user ): ?>
<div class="abt-staff clearfix">
    <?php echo get_avatar( $user->ID, 60 ); ?>
    <h4><a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php the_author_meta( 'display_name', $user->ID ); ?></a></h4>
    <h5><?php the_author_meta( 'sw_title', $user->ID ); ?></h5>
    <p><?php the_author_meta( 'description', $user->ID ); ?></p>
</div><!-- /.abt-staff -->
<? endforeach; ?>

<h3>Partner Stations</h3>
<?php $stations = get_stations(); ?>
<?php while ( $stations->have_posts() ): ?>
    <?php $stations->the_post(); ?>
    
    <dl class="partner-station">
        <dt><a href="<?php echo get_post_meta( get_the_ID(), 'url', true ); ?>"><?php the_title(); ?></a></dt>
        <dd class="station-logo">
        <?php if ( has_post_thumbnail() ) { the_post_thumbnail( array(140) ); } ?>
        </dd>
        <dd><?php echo get_post_meta( get_the_ID(), 'city', true); ?> <b><?php echo get_post_meta( get_the_ID(), 'frequency', true ); ?></b></dd>
        <dd><a href="<?php echo get_post_meta( get_the_ID(), 'support_url', true ); ?>">Support</a></dd>
    </dl>
<?php endwhile; ?>
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
<?php get_sidebar( 'about' ); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
