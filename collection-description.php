<?php
$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
?>

<div id="coll-intro" class="grid_12 coll-dl"> 
<h2><?php echo $topic->post_title; ?></h2> 

<div class="coll-desc clearfix"> 
<h6>Background</h6>
<?php echo apply_filters( 'the_content', $topic->post_content ); ?>
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
</div> <!-- /#coll-intro .grid_12 --> 