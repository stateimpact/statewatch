<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  
 */
$blogger = argo_get_primary_blogger(); 
?>
</div> <!-- #main .container_12 -->

<!--[if (gte IE 9)|!(IE)]><!-->   <footer id="site-footer" class="clearfix"><!--<![endif]-->
<!--[if lte IE 8]>   <div id="site-footer" class="clearfix"> <![endif]-->

<div class="container_12">
<div class="grid_2">

<div class="bio">
    <?php if ( $blogger ): ?>
        <?php echo get_avatar( $blogger->ID, 140 ); ?>
        <p>Questions, comments, story ideas. Get in touch.</p>
        <h6><a href="<?php echo argo_get_in_touch_link(); ?>" title="get in touch">GET IN TOUCH</a></h6>
    <?php endif; ?>
</div> <!-- /.bio -->

<div class="elsewhere">
    <h4>FOLLOW US</h4>

    <ul>
        <li class="subscribe"><?php echo the_feed_link( 'RSS' ); ?></li>
    
    <?php if ( get_option( 'podcast_link' ) ) :?>
        <li class="podcast">
            <a href="<?php echo get_option( 'podcast_link' ); ?>">Podcast</a>
        </li>
    <?php endif; ?>
    
    <?php if ( get_option( 'facebook_link' ) ) : ?>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/img/fb16.png" alt="facebook-fav" width="16" height="16" />
            <a href="<?php echo get_option( 'facebook_link' ); ?>" title="Facebook">Facebook</a>
        </li>
    <?php endif; ?>

    <?php if ( get_option( 'twitter_link' ) ) : ?>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/img/twitter16.png" alt="twitter-fav" width="16" height="16" />
            <a href="<?php echo get_option( 'twitter_link' ); ?>" title="twitter">Twitter</a>
        </li>
    <?php endif; ?>

    <?php if ( get_option( 'youtube_link' ) ) : ?>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/img/youtube16.png" alt="youtube-fav" width="16" height="16" />
            <a href="<?php echo get_option( 'youtube_link' ); ?>" title="youtube">YouTube</a>
        </li>
    <?php endif; ?>

    <?php if ( get_option( 'flickr_link' ) ) : ?>
        <li>
            <img src="<?php bloginfo('template_directory'); ?>/img/flickr16.png" alt="flickr-fav" width="16" height="16" />
            <a href="<?php echo get_option( 'flickr_link' ); ?>" title="flickr">Flickr</a>
        </li>
    <?php endif; ?>
    </ul>
</div>
<?php do_action( 'navis_below_footer_bio' ); ?>
<!-- /.elsewhere -->
<!--
<div class="email">
    <h4 class='email-footer'>Receive Daily Email Updates</h4>
        <form id='feedburner-subscribe-sidebar' class='feedburner sidebar'
        action='http://feedburner.google.com/fb/a/mailverify' method='post' target='popupwindow' 
        onsubmit='window.open('http://feedburner.google.com/fb/a/mailverify?uri=$uri', 'popupwindow', 'scrollbars=yes,width=550,height=520');
        return true'>
        <input type='text' style='width:140px' name='email' placeholder='email address' />
        <input type='submit' value='Subscribe' /><p>
        <input type='hidden' value='$uri' name='uri'/>
        <input type='hidden' name='loc' value='en_US'/>
        </form>
</div>
-->
</div>
<!-- /.grid_2 -->

<div class="grid_6">

<div class="about-site">
<?php if ( get_option( 'support_link' ) ) : ?>
    <h6><a href="<?php echo get_option( 'support_link' ); ?>" title="support">SUPPORT THIS SITE</a></h6>
<?php endif; ?>

<?php if ( $blogger ) : ?>
    <h3>ABOUT THIS SITE</h3>
    <p><?php echo $blogger->description; ?></p>
<?php endif; ?>

</div>
<!-- /.about-site -->

<div class="missed-it">
    <?php $missedit = navis_get_featured_posts( array( 'offset' => 3, 'showposts' => 2 ) );
          if ( $missedit->have_posts() ) : ?>
              <h3>IN CASE YOU MISSED IT</h3>
              <?php while ( $missedit->have_posts() ) : $missedit->the_post(); ?>
                  <div class="post-lead">
                      <?php the_post_thumbnail( '60x60' ); ?>
                      <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                     <?php the_excerpt(); ?>
                  </div> <!-- /.post-lead -->
            <?php endwhile;
         endif; ?>
</div> <!-- /.missed-it -->

</div>
<!-- /.grid_6 -->

<div class="grid_4">

<form role="search" method="get" id="searchform-footer" action="<?php bloginfo('url'); ?>">
	<div><label class="visuallyhidden" for="s1">Search for:</label>
	<input type="text" placeholder="SEARCH" value="" name="s" id="s1" />
	<input type="image" src="<?php bloginfo('template_directory'); ?>/img/btn-go.png" alt="Submit" width="32" height="24" id="search-submit" />
	</div>
</form>
<!-- /#searchform-footer -->
<div class="must-read-footer">
    <h3>READ MORE ABOUT:</h3>
    <?php wp_nav_menu( array( 'theme_location' => 'read-more-about', 'container' => false ) ); ?>
    <p><a href="<?php echo get_static_page_link( 'topic-index' ); ?>" title="view all topics">View all topics</a></p>
</div>
<!-- /.must-read-footer -->



<div id="ft-archive">
    <h3>BROWSE ARCHIVES BY DATE</h3>
    
   <select name="archive-dropdown" onChange='document.location.href=this.options[this.selectedIndex].value;'> 
  <option value="">Select Month</option> 
  <?php wp_get_archives('type=monthly&format=option&show_post_count=1'); ?> </select>
</div>

</div>
<!-- /.grid_4 -->

<div id="boilerplate" class="grid_12">
    <dl class="our-partners">
        <dt>OUR PARTNERS</dt>
        <dd><a href="http://www.knightfoundation.org/" title="Knight Foundation" target="_blank">
            <img src="<?php bloginfo('template_directory'); ?>/img/logo-knight-30.png" alt="Knight Logo" width="142" height="30" /></a></dd>
        <dd><a href="http://www.cpb.org/" title="Corporation for Public Broadcasting" target="_blank">
            <img src="<?php bloginfo('template_directory'); ?>/img/logo-cpb-30x30.png" alt="Corporation for Public Broadcasting" width="30" height="30" />
        </a></dd>
        <dd><a href="http://www.npr.org/" title="NPR" target="_blank">
            <img src="<?php bloginfo('template_directory'); ?>/img/logo-npr-footer.png" alt="NPR" width="90" height="30" />
        </a></dd>
    </dl>
    <!-- /.our-partners -->
    <p><?php argo_copyright_message(); ?></p>
    <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false ) ); ?>
    <p class="back-to-top"><a href="#main">Back to top &uarr;</a></p>
</div>
<!-- /.grid_12 -->
</div>
<!-- /.container_12 -->
<!--[if (gte IE 9)|!(IE)]><!--> </footer><!--<![endif]-->
<!--[if lte IE 8]></div><![endif]-->
<!-- #footer -->

</div><!-- #wrapper -->
<!--[if lte IE 6]><script src="<?php bloginfo('template_directory'); ?>/js/unitpngfix.js"></script><![endif]-->

<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.hoverIntent.minified.js"></script>

<script src="<?php bloginfo('template_directory'); ?>/js/jquery.textPlaceholder.js"></script>

<script type="text/javascript">
        jQuery(document).ready(function() {
            //html5 placeholders
            $("input[placeholder]").textPlaceholder();

            //main navigation	
            function megaHoverOver(){
                $(this).find(".sub").stop().fadeTo('fast', 1).show();
            }

            function megaHoverOut(){ 
                $(this).find(".sub").stop().fadeTo('fast', 0, function() {
                    $(this).hide(); 
                });
            }
            var config = {    
                sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)    
                    interval: 100, // number = milliseconds for onMouseOver polling interval    
                    over: megaHoverOver, // function = onMouseOver callback (REQUIRED)    
                    timeout: 500, // number = milliseconds delay before onMouseOut    
                    out: megaHoverOut // function = onMouseOut callback (REQUIRED)    
            };

            $("ul#topnav li .sub").css({'opacity':'0'});
            $("ul#topnav li").hoverIntent(config);
        });
</script>


<script src="<?php bloginfo('template_directory'); ?>/js/sm.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/sm.playlist.js"></script>

<script>
soundManager.url = '<?php bloginfo('template_directory'); ?>/inc/audio/';

function setTheme(sTheme) {
  var o = document.getElementsByTagName('ul')[0];
  o.className = 'playlist'+(sTheme?' '+sTheme:'');
  return false;
}

</script>

<?php get_template_part( 'audio-controls' ); ?>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>

<?php
/*
if ( current_user_can( 'administrator' ) ) {
    global $wpdb;

    echo "<pre>";
    print_r($wpdb->queries);
    echo "</pre>";

    global $wp_object_cache;
    echo $wp_object_cache->_get_debug_info();
}
 */
?>
</body>
</html>
