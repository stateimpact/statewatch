<?php

add_action( 'show_user_profile', 'sw_staff_fields' );
add_action( 'edit_user_profile', 'sw_staff_fields' );

function get_blog_id() {
	global $current_blog;
	return $current_blog->blog_id;
}

function sw_staff_fields( $user ) { 
	$blog_id = get_blog_id();
	?>
    <h3>StateImpact</h3>

	<table class="form-table">
		<tr>
			<th><label for="sw_title">Title</label></th>
			<td>
				<input type="text" name="sw_title" id="sw_title" value="<?php echo esc_attr( get_the_author_meta( 'sw_title', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your staff title for the StateImpact project.</span>
			</td>
		</tr>
		
		<tr>
			<th><label for="sw_twitter">Twitter</label></th>
			<td>
				<input type="text" name="sw_twitter" id="sw_twitter" value="<?php echo esc_attr( get_the_author_meta( 'sw_twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Twitter ID.</span>
			</td>
		</tr>
		
		<tr>
		    <th><label for="sw_is_staff">Staff reporter status</label></th>
		    <td>
		        <input type="checkbox" name="sw_is_staff" id="sw_is_staff" <?php checked( get_the_author_meta( "sw_is_staff:" . $blog_id, $user->ID ), 1 ); ?> /><br />
		        <span class="description">Staff reporters show up in the site footer</span>
		    </td>
		</tr>		
	</table>
    <?php
}

add_action( 'personal_options_update', 'sw_update_staff_fields' );
add_action( 'edit_user_profile_update', 'sw_update_staff_fields' );

function sw_update_staff_fields( $user_id ) {
	$blog_id = get_blog_id();

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	$fields = array('sw_title', 'sw_twitter', 'sw_order');
	foreach($fields as $field) {
	    if (isset($_POST[$field])) {
	        update_user_meta( $user_id, $field, $_POST[$field]);
	    }
	}
	if ($_POST['sw_is_staff'] == 'on') {
	    update_user_meta($user_id, "sw_is_staff:" . $blog_id, 1);
	} else {
	    update_user_meta($user_id, "sw_is_staff:" . $blog_id, 0);
	}
}

function sw_get_staff() {
	$blog_id = get_blog_id();
    return get_users( array(
                'meta_key' => "sw_is_staff:" . $blog_id,
                'meta_value' => 1,
                'orderby' => 'registered',
            ) );
}

?>