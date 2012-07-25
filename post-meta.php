
<ul class="meta-gestures">
    <li class="meta-comments"><span class="comments-link"><?php comments_popup_link( 'Comment', '<strong>1</strong> Comment ', ' <strong>%</strong> Comments' ); ?></span></li>
	<?php sw_the_email_link(); ?>
    <li class="twitter"> 
        <a href="<?php echo esc_url( 'http://twitter.com/share?url=' . get_permalink() . '&text=' ) . argo_get_twitter_title(); ?>" class="twitter-share-button" data-count="horizontal">Tweet</a>
    </li>
    <li class="fb">
        <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="200" data-show-faces="false" data-action="recommend" data-font="arial"></div>
    </li>
</ul>
