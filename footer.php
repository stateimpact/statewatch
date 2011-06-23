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
</div> <!-- #local-wrapper -->

<!--[if (gte IE 9)|!(IE)]><!-->   <footer id="site-footer" class="clearfix"><!--<![endif]-->
<!--[if lte IE 8]>   <div id="site-footer" class="clearfix"> <![endif]-->

<div class="container_12">
<div class="grid_3">
<h3 id="footerlogo"><a href="<?php bloginfo('stylesheet_directory'); ?>/hub.html" title="StateImpact" class="unitPng">StateImpact</a></h3>
<h4 id="footerstate"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>" class="unitPng">
            <?php bloginfo('name'); ?>
        </a></h4>
<ul id="colophon">
    <li><?php echo "Copyright " . date('Y') . " " . get_option('copyright_holder'); ?></li>
    <li><a href="<?php echo get_option('tos_link'); ?>">Terms of Use</a></li>
    <li><a href="<?php echo get_option('privacy_link'); ?>">Privacy Policy</a></li>
    <?php if (get_option('support_link')): ?>
    <li class="donate"><a href="<?php echo get_option('support_link'); ?>">Support</a></li>
    <?php else: ?>
    <li class="donate"><a href="http://www.npr.org/stations/donate/index.php?ps=st273">Support</a></li>
    <?php endif; ?>
</ul>

</div>
<!-- /.grid_3 -->
<div class="grid_3">
    <h3>Staff</h3>
    <?php $users = sw_get_staff(); ?>
    <?php foreach ( $users as $user ): ?>
        <div class="ft-reporter clearfix">
            <?php echo get_avatar( $user->ID, 60 ); ?>
            <h4><a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php the_author_meta( 'display_name', $user->ID ); ?></a></h4>
            <h5><?php the_author_meta( 'sw_title', $user->ID ); ?></h5>
        </div><!-- /.ft-reporter -->
    <?php endforeach; ?>
</div>
<!-- /.grid_3 -->

<div class="grid_3">
    <h3>Partners</h3>
    <?php $stations = sw_get_stations(); ?>
    <?php while ( $stations->have_posts() ): ?>
        <?php $stations->the_post(); ?>
        <dl class="partner-station">
            <dt><a href="<?php echo get_post_meta( get_the_ID(), 'url', true ); ?>"><?php the_title(); ?></a></dt>
            <dd><?php echo get_post_meta( get_the_ID(), 'city', true ); ?></dd>
        </dl>
    <?php endwhile; ?>
</div>
<!-- /.grid_3 -->

<div class="grid_3">

<div id="ft-archive">
    <h3>Archives</h3>
    
   <select name="archive-dropdown" onChange='document.location.href=this.options[this.selectedIndex].value;'> 
  <option value="">Select Month</option> 
  <?php wp_get_archives('type=monthly&format=option&show_post_count=1'); ?> </select>
</div>

<form role="search" method="get" id="searchform-footer" action="<?php bloginfo('url'); ?>">
	<div><label class="visuallyhidden" for="s1">Search for:</label>
	<input type="text" placeholder="SEARCH" value="" name="s" id="s1" />
	<input type="image" src="<?php bloginfo('template_directory'); ?>/img/btn-go.png" alt="Submit" width="32" height="24" id="search-submit" />
	</div>
</form>
<!-- /#searchform-footer -->

<h4><a href="#">View all topics &raquo;</a></h4>

</div>
<!-- /.grid_3 -->

<div id="boilerplate" class="grid_12">

    <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false ) ); ?>
    <p class="back-to-top visuallyhidden"><a href="#main">Back to top &uarr;</a></p>
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

<!-- argo network panel -->
<script src="<?php bloginfo('template_url'); ?>/js/jquery.idTabs.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/jquery.collapser.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#apanel-trigger').collapser({
        target: '#argo-panel',
        expandHtml: 'Other states',
        collapseHtml: 'Close states',
        expandClass: 'cpanel',
        collapseClass: 'opanel'
    });

    // toggle panel
    $('#apanel-trigger').click(function() {
        $('#apanel-content').slideToggle(400);
        return false;
    });
	
    // delay image loading
    var delayedLoad = function(event) {
        $('div.panel-featured-img').each(function(i) {
            var src = $(this).attr('data-src');
            if (src) {
                var img = $('<img/>')
                    .attr('src', src)
                    .attr('alt', 'f-story')
                    .attr('height', '60')
                    .attr('width', '60');
                $(this).prepend(img);
        };
        });
        $('#apanel-trigger').unbind('click', delayedLoad);
    };
    $('#apanel-trigger').click(delayedLoad);

    
    // show network features
    var starter = function() {
            var links, index, blog, id;
            links = $('div#panel-network').find('a'); 
            index = Math.floor( Math.random() * links.length ); 
            blog = links[index];
            if (blog) return blog.getAttribute('href');
    };
    $("#panel-network").idTabs(starter()); 
});
</script>

<div id="apanel-content" class="container_12"> 
    <div id="argo-inner-panel">
        <div id="panel-about" class="grid_4 alpha">
            <h5>About StateImpact</h5>
            <p>StateImpact seeks to inform and engage local communities with broadcast and online news focused on how state government decisions affect your lives. <br>
                <a href="<?php bloginfo('stylesheet_directory'); ?>/hub.html" title="<?php bloginfo('name'); ?>">Learn More &raquo;</a></p>
        </div>

        <div id="topic-budget" class="network-sites grid_2">
			<h5>Budget</h5>
			<ul>
				<li>Oklahoma</li>
			</ul>
		</div>

		<div id="topic-economy" class="network-sites grid_2">
			 <h5>Economy</h5>
			<ul>
				<li><a href="#">New Hampshire</a></li>
				<li>Idaho</li>
			 </ul>
	    </div>
	
		<div id="topic-economy" class="network-sites grid_2">
			<h5>Education</h5>
			<ul>
				<li><a href="#">Florida</a></li>
				<li><a href="#">Ohio</a></li>
				<li>Indiana</li>
			</ul>
		</div>
		<div id="topic-economy" class="network-sites grid_2 omega">
			<h5>Energy</h5>
			<ul>
				<li><a href="#">Pennsylvania</a></li>
				<li>Texas</li>
			</ul>
		</div>

    </div> <!-- /#argo-inner-panel -->
</div> <!-- /#apanel-content -->

</body>
</html>
