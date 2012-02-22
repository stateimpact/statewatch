<?php
$cat = $wp_query->get_queried_object();
$topic = argo_get_topic_for( $cat );
?>
<?php if ( $topic->post_content ): ?>
	<div class="topic-intro post post-content clearfix"> 
		<h2 class="section-hed">Background</h2>
		<ul class="meta-gestures">
		    <li class="twitter"> 
		        <a href="<?php echo esc_url( 'http://twitter.com/share?url=' . $topic->guid . '&text=' ) . rawurlencode( $topic->post_title ); ?>" class="twitter-share-button" data-count="horizontal">Tweet</a>
		    </li>
		    <li class="fb">
                <div id="fb-root"></div>
                <div class="fb-like" data-href="<?php echo esc_url($topic->guid); ?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false" data-action="recommend"></div>
            </li>
		</ul>	
	    <?php 
		    $content = apply_filters( 'the_content', $topic->post_content ); 
		    $content = explode('<!--more-->', $content);
		    echo $content[0];
		    if ($content[1]){
		   		echo '<div id="more">' . $content[1] . '</div>';
		    }
	    ?>
	</div>
	<script>
        jQuery(function($) {
            $('#more').fadeOut()
            		  .after('<a id="more-button" href="javascript:void">Read more &raquo;</a>');
            $('#more-button').click(function() {
				$('#more').fadeToggle();
				$('#more-button').remove();
			});
          
        });
    </script>
<?php endif; ?>
