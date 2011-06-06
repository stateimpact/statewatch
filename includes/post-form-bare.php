<?
/***
This is a copy of the standard WordPress post form, from edit-form-advanced.php,
but with the <form/> tag removed. This is everything formerly between <form> and </form>.
***/
?>

<?php wp_nonce_field($nonce_action); ?>
<input type="hidden" name="parent_id" value="<?php echo esc_attr( $post->post_parent ); ?>" />
<input type="hidden" id="user-id" name="user_ID" value="<?php echo (int) $user_ID ?>" />
<input type="hidden" id="hiddenaction" name="action" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="originalaction" name="originalaction" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="post_author" name="post_author" value="<?php echo esc_attr( $post->post_author ); ?>" />
<input type="hidden" id="post_type" name="post_type" value="<?php echo esc_attr( $post_type ) ?>" />
<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo esc_attr( $post->post_status) ?>" />
<input type="hidden" id="referredby" name="referredby" value="<?php echo esc_url(stripslashes(wp_get_referer())); ?>" />
<?php
if ( 'draft' != $post->post_status )
	wp_original_referer_field(true, 'previous');

echo $form_extra;

wp_nonce_field( 'autosave', 'autosavenonce', false );
wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
?>

<div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
<div id="side-info-column" class="inner-sidebar">

<?php
('page' == $post_type) ? do_action('submitpage_box') : do_action('submitpost_box');
$side_meta_boxes = do_meta_boxes($post_type, 'side', $post);
?>
</div>

<div id="post-body">
<div id="post-body-content">
<?php if ( post_type_supports($post_type, 'title') ) { ?>
<div id="titlediv">
<div id="titlewrap">
	<label class="hide-if-no-js" style="visibility:hidden" id="title-prompt-text" for="title"><?php echo apply_filters( 'enter_title_here', __( 'Enter title here' ), $post ); ?></label>
	<input type="text" name="post_title" size="30" tabindex="1" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
</div>
<div class="inside">
<?php
$sample_permalink_html = ! empty( $post_type_object->publicly_queryable ) ? get_sample_permalink_html($post->ID) : '';
$shortlink = wp_get_shortlink($post->ID, 'post');
if ( !empty($shortlink) )
    $sample_permalink_html .= '<input id="shortlink" type="hidden" value="' . esc_attr($shortlink) . '" /><a href="#" class="button" onclick="prompt(&#39;URL:&#39;, jQuery(\'#shortlink\').val()); return false;">' . __('Get Shortlink') . '</a>';

if ( ! empty( $post_type_object->publicly_queryable ) && ! ( 'pending' == $post->post_status && !current_user_can( $post_type_object->cap->publish_posts ) ) ) { ?>
	<div id="edit-slug-box">
	<?php
		if ( ! empty($post->ID) && ! empty($sample_permalink_html) && 'auto-draft' != $post->post_status )
			echo $sample_permalink_html;
	?>
	</div>
<?php
}
?>
</div>
<?php
wp_nonce_field( 'samplepermalink', 'samplepermalinknonce', false );
?>
</div>
<?php } ?>

<?php if ( post_type_supports($post_type, 'editor') ) { ?>
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">

<?php the_editor($post->post_content); ?>

<table id="post-status-info" cellspacing="0"><tbody><tr>
	<td id="wp-word-count"></td>
	<td class="autosave-info">
	<span id="autosave">&nbsp;</span>
<?php
	if ( 'auto-draft' != $post->post_status ) {
		echo '<span id="last-edit">';
		if ( $last_id = get_post_meta($post_ID, '_edit_last', true) ) {
			$last_user = get_userdata($last_id);
			printf(__('Last edited by %1$s on %2$s at %3$s'), esc_html( $last_user->display_name ), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		} else {
			printf(__('Last edited on %1$s at %2$s'), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		}
		echo '</span>';
	} ?>
	</td>
</tr></tbody></table>

</div>

<?php
}

do_meta_boxes($post_type, 'normal', $post);

( 'page' == $post_type ) ? do_action('edit_page_form') : do_action('edit_form_advanced');

do_meta_boxes($post_type, 'advanced', $post);

do_action('dbx_post_sidebar'); ?>

</div>
</div>
<br class="clear" />
</div><!-- /poststuff -->
