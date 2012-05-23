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
<!-- 
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
-->
<!-- /.alpha-nav -->

<script type="text/javascript" charset="utf-8">
String.prototype.score = function(abbreviation,offset) {
  offset = offset || 0 // TODO: I think this is unused... remove
 
  if(abbreviation.length == 0) return 0.9
  if(abbreviation.length > this.length) return 0.0

  for (var i = abbreviation.length; i > 0; i--) {
    var sub_abbreviation = abbreviation.substring(0,i)
    var index = this.indexOf(sub_abbreviation)


    if(index < 0) continue;
    if(index + abbreviation.length > this.length + offset) continue;

    var next_string       = this.substring(index+sub_abbreviation.length)
    var next_abbreviation = null

    if(i >= abbreviation.length)
      next_abbreviation = ''
    else
      next_abbreviation = abbreviation.substring(i)
 
    var remaining_score   = next_string.score(next_abbreviation,offset+index)
 
    if (remaining_score > 0) {
      var score = this.length-next_string.length;

      if(index != 0) {
        var j = 0;

        var c = this.charCodeAt(index-1)
        if(c==32 || c == 9) {
          for(var j=(index-2); j >= 0; j--) {
            c = this.charCodeAt(j)
            score -= ((c == 32 || c == 9) ? 1 : 0.15)
          }
        } else {
          score -= index
        }
      }
   
      score += remaining_score * next_string.length
      score /= this.length;
      return score
    }
  }
  return 0.0
}
jQuery.fn.liveUpdate = function(list){
  list = jQuery(list);
  if ( list.length ) {
    var rows = list.children('li'),
      cache = rows.map(function(){
        return this.firstChild.innerHTML.toLowerCase();
      });
      
    this
      .keyup(filter).keyup()
      .parents('form').submit(function(){
        return false;
      });
  }
    
  return this;
    
  function filter(){
    var term = jQuery.trim( jQuery(this).val().toLowerCase() ), scores = [];
    
    if ( !term ) {
      rows.show();
    } else {
      rows.hide();

      cache.each(function(i){
        var score = this.score(term);
        if (score > 0) { scores.push([score, i]); }
      });

      jQuery.each(scores.sort(function(a, b){return b[0] - a[0];}), function(){
        jQuery(rows[ this[1] ]).show();
      });
    }
  }
};



    jQuery(document).ready(function() {
        jQuery('#term').liveUpdate('#tags').focus();
    });
</script>

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
		<ul id="tags" class="abc_tags">
	<?php
	foreach($post_tags as $key => $tag) {
    ?>
			<li><a href="<?php echo get_tag_link($tag->term_id); ?>" title="<?php echo sprintf( __( "View all posts in %s" ), $tag->name ); ?>"><?php echo $tag->name.' </a><span class="count">'.$tag->count.'</span>';?></li>
			
	<?php }	?>
		
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
