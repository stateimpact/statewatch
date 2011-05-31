<?php

add_action( 'show_user_profile', 'sw_staff_fields' );
add_action( 'edit_user_profile', 'sw_staff_fields' );

function sw_staff_fields( $user ) { ?>
    <h3>StateWatch</h3>

	<table class="form-table">
		<tr>
			<th><label for="sw_title">Title</label></th>
			<td>
				<input type="text" name="sw_title" id="sw_title" value="<?php echo esc_attr( get_the_author_meta( 'sw_title', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your staff title for the StateWatch project.</span>
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
		    <th><label for="sw_is_staff">Staff status</label></th>
		    <td>
		        <input type="checkbox" name="sw_is_staff" id="sw_is_staff" value="1" <?php checked( 1, get_the_author_meta( 'sw_is_staff', $user->ID ) ); ?> /><br />
		        <span class="description">Are you on staff?</span>
		    </td>
		</tr>
	</table>
    <?php
}

add_action( 'personal_options_update', 'sw_update_staff_fields' );
add_action( 'edit_user_profile_update', 'sw_update_staff_fields' );

function sw_update_staff_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_usermeta( $user_id, 'sw_title', $_POST['sw_title'] );
	update_usermeta( $user_id, 'sw_twitter', $_POST['sw_twitter'] );
	update_usermeta( $user_id, 'sw_is_staff', $_POST['sw_is_staff']);
}

function sw_get_staff() {
    return get_users(
            array(
                'meta_key' => 'sw_is_staff',
                'meta_value' => 1
            )
        );
}

?>