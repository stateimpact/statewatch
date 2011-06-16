
<ul class="meta-gestures">
    <li class="meta-comments"><span class="comments-link"><?php comments_popup_link( 'Comment', '<strong>1</strong> Comment ', ' <strong>%</strong> Comments' ); ?></span></li>
    <li class="twitter"> 
        <a href="<?php echo esc_url( 'http://twitter.com/share?url=' . get_permalink() . '&text=' ) . argo_get_twitter_title(); ?>" class="twitter-share-button" data-count="horizontal">Tweet</a>
    </li>
    <li class="fb">
        <a name="fb_share" share_url="<?php the_permalink(); ?>" type="button_count" href="<?php echo esc_url( 'http://www.facebook.com/sharer.php?u=' . get_permalink() . '&t=' ) . get_the_title();  ?>">Share</a>
    </li>
    <?php argo_the_email_link(); ?>
</ul>
