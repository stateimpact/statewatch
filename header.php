<!DOCTYPE html>
<?php
/**
 * Displays all of the <head> section and everything up till <div id="main">
 */
?>
<!--[if lt IE 7]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<?php do_action('meta_tags'); ?>
	<title>
	<?php // Returns the title based on what is being viewed
		if ( is_single() ) { // single posts
			single_post_title(); echo ' | StateImpact '; bloginfo( 'name' );
		// The home page or, if using a static front page, the blog posts page.
		} elseif ( is_home() || is_front_page() ) {
			echo 'StateImpact ' . get_bloginfo( 'name' );
			if( get_bloginfo( 'description' ) )
				echo ' | ' ; bloginfo( 'description' );
			argo_the_page_number();
		} elseif ( is_page() ) { // WordPress Pages
			single_post_title( '' ); echo " |  StateImpact " . get_bloginfo( 'name' );
		} elseif ( is_search() ) { // Search results
			printf( 'Search results for %s', '"'.get_search_query().'"' ); argo_the_page_number(); echo ' | StateImpact '; bloginfo( 'name' );
		} elseif ( is_404() ) {  // 404 (Not Found)
			echo 'Not Found | StateImpact '; bloginfo( 'name' );
		} else { // Otherwise:
			wp_title( '' ); echo ' | StateImpact '; bloginfo( 'name' ); argo_the_page_number();
		}
	?>
	</title>
	
	<script type="text/javascript" src="http://use.typekit.com/yey2zgp.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	
	<link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.png"/>
	<link rel="apple-touch-icon-precomposed" href="<?php bloginfo('stylesheet_directory'); ?>/img/apple-touch-icon-precomposed.png"/> 
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?v=4" />
	<link rel="stylesheet" media="handheld" href="<?php bloginfo('template_directory'); ?>/css/handheld.css?v=1" />

<script src="<?php bloginfo('template_directory'); ?>/js/modernizr-1.6.min.js"></script>

                
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */

	wp_head();
?>

<?php get_template_part('customstyle');?>

<?php 
        if ( is_singular() ) {
            argo_prominence_tracker();
            $thumb = argo_get_the_post_thumbnail_src();
            if ( $thumb ) {
?>
                <link rel="thumbnail" href="<?php echo $thumb; ?>" />
<?php
            }
        }
?>

<!-- Outbound links analytics -->
<script type="text/javascript">
	var NavisAnalyticsFileTypes = ['pdf','mp3'];
</script>
<script>
// what things can i click on that should be tracked
_clickEvents = [
    // selector, category
    {category: 'Featured Topics', selector: 'div.featured-topics a'},
    {category: 'Mega Menu', selector: '#topnav a'}
];

</script>
<script src="<?php bloginfo('template_directory'); ?>/js/tracking.js"></script>
</head>

<body <?php body_class(); ?>>

<div id="wrapper" class="hfeed">
    <div class="global-nav-bg"> 
		<nav class="global-nav">
	
				<h2><a href="/" title="StateImpact" class="unitPng">StateImpact</a></h2>
				<h4><a href="http://npr.org" title="Visit npr.org">In partnership with NPR</a></h4>
				<ul class="global-utils">
					<li><a href="./about/">About StateImpact</a> </li>
					<li><a id="apanel-trigger" href="#">Other states</a></li>
				</ul>
		        <span class="visuallyhidden"><a href="#main" title="Skip to content">Skip to content</a></span>

		<!--<img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo-npr-header.png" alt="NPR logo" width="54" height="18" id="npr-bug"> -->
		</nav><!-- /.global-nav -->
		<div id="argo-panel-wrapper"><div id="argo-panel"></div></div><!-- /#argo-panel-wrapper -->
    </div> <!-- /.global-nav-bg -->
<div id="local-wrapper">
	<div id="global-branding" class="clearfix">

		<header>
		    <h3>
		        <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>" class="unitPng">
		            <?php bloginfo('name'); ?>
		        </a>
		    </h3>
		    <h4><?php bloginfo('description'); ?></h4>
		</header>

	   <div id="category-nav">
	        <nav>
	        <?php wp_nav_menu( array( 'theme_location' => 'categories', 'container' => false , 'menu_id' => 'topnav', 'walker' => new Argo_Categories_Walker, 'depth' => 1 ) ); ?>
	        </nav><!-- /#mega menu -->
		</div> <!-- /main-nav -->

	</div><!-- /#global-branding -->
	<div id="main" class="container_12 clearfix">
