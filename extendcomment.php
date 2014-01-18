<?php
/*
Plugin Name: Extend Comment Form
Version: 1.2
Plugin URI: http://cherrypj.com
Description: A plug-in to add additional fields in the comment form. From: http://wp.smashingmagazine.com/2012/05/08/adding-custom-fields-in-wordpress-comment-form/. Also, add the extra fields to the notify moderator/admin email. 
Author: Michael Hessling
Author URI: http://cherrypj.com
*/

// Add custom meta fields to the default comment form
// Default comment form includes name, email, in comments.php
// Add fields after default fields above the comment box, always visible
add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_after_fields', 'additional_fields' );

function additional_fields () {
	echo '<fieldset class="comment-form-address">'.
	'<label for="address">' . __( 'Street Address:' ) . '</label>'.
	'<input id="address" name="address" type="text" size="30" class="form-text" /></fieldset>';

	echo '<fieldset class="comment-form-city">'.
	'<label for="city">' . __( 'City:' ) . '</label>'.
	'<input id="city" name="city" type="text" size="30" class="form-text" /></fieldset>';

	echo '<fieldset class="comment-form-state">'.
	'<label for="state">' . __( 'State:' ) . '</label>'.
	'<select id="state" name="state">
		<option value="MA">Massachusetts</option>
		<option value="AL">Alabama</option>
		<option value="AK">Alaska</option>
		<option value="AZ">Arizona</option>
		<option value="AR">Arkansas</option>
		<option value="CA">California</option>
		<option value="CO">Colorado</option>
		<option value="CT">Connecticut</option>
		<option value="DE">Delaware</option>
		<option value="DC">District Of Columbia</option>
		<option value="FL">Florida</option>
		<option value="GA">Georgia</option>
		<option value="HI">Hawaii</option>
		<option value="ID">Idaho</option>
		<option value="IL">Illinois</option>
		<option value="IN">Indiana</option>
		<option value="IA">Iowa</option>
		<option value="KS">Kansas</option>
		<option value="KY">Kentucky</option>
		<option value="LA">Louisiana</option>
		<option value="ME">Maine</option>
		<option value="MD">Maryland</option>
		<option value="MI">Michigan</option>
		<option value="MN">Minnesota</option>
		<option value="MS">Mississippi</option>
		<option value="MO">Missouri</option>
		<option value="MT">Montana</option>
		<option value="NE">Nebraska</option>
		<option value="NV">Nevada</option>
		<option value="NH">New Hampshire</option>
		<option value="NJ">New Jersey</option>
		<option value="NM">New Mexico</option>
		<option value="NY">New York</option>
		<option value="NC">North Carolina</option>
		<option value="ND">North Dakota</option>
		<option value="OH">Ohio</option>
		<option value="OK">Oklahoma</option>
		<option value="OR">Oregon</option>
		<option value="PA">Pennsylvania</option>
		<option value="RI">Rhode Island</option>
		<option value="SC">South Carolina</option>
		<option value="SD">South Dakota</option>
		<option value="TN">Tennessee</option>
		<option value="TX">Texas</option>
		<option value="UT">Utah</option>
		<option value="VT">Vermont</option>
		<option value="VA">Virginia</option>
		<option value="WA">Washington</option>
		<option value="WV">West Virginia</option>
		<option value="WI">Wisconsin</option>
		<option value="WY">Wyoming</option>
	</select></fieldset>';

	echo '<fieldset class="comment-form-zip">'.
	'<label for="zip">' . __( 'Zip Code:' ) . '</label>'.
	'<input id="zip" name="zip" type="text" size="30" class="form-text" /></fieldset>';

	echo '<fieldset class="comment-form-phone">'.
	'<label for="phone"><span class="required">* </span> ' . __( 'Telephone:' ) . '</label>'.
	'<input id="phone" name="phone" type="tel" size="30" class="form-text" /></fieldset>';

	echo '<fieldset class="comment-form-request radio">'.
	'<label for="request">' . __( 'I would like to:' ) . '</label>'.
	'<ul><li><label><input name="request[]" id="request-brochure" type="checkbox" value="RequestBrochure" />Request a Brochure</label></li>' .
	'<li><label><input name="request[]" id="request-schedule" type="checkbox" value="ScheduleTour" />Schedule a Tour</label></li>' .
	'<li><label><input name="request[]" id="request-question" type="checkbox" value="AskQuestion" />Ask a Question</label></li>' .
	'<li><label><input name="request[]" id="request-other" type="checkbox" value="Other" />Other</label></li></ul></fieldset>';

	echo '<fieldset class="comment-form-other">'.
	'<label for="other">' . __( 'Other:' ) . '</label>'.
	'<input id="other" name="other" type="text" size="30" class="form-text" /></fieldset>';

}


// Save the comment meta data along with comment

add_action( 'comment_post', 'save_comment_meta_data' );
function save_comment_meta_data( $comment_id ) {
	if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') ) {
		$phone = wp_filter_nohtml_kses($_POST['phone']);
		add_comment_meta( $comment_id, 'phone', $phone );
	}

	if ( ( isset( $_POST['address'] ) ) && ( $_POST['address'] != '') ) {
		$address = wp_filter_nohtml_kses($_POST['address']);
		add_comment_meta( $comment_id, 'address', $address ); 
	}

	if ( ( isset( $_POST['city'] ) ) && ( $_POST['city'] != '') ) {
		$city = wp_filter_nohtml_kses($_POST['city']);
		add_comment_meta( $comment_id, 'city', $city );
	}

	if ( ( isset( $_POST['state'] ) ) && ( $_POST['state'] != '') ) {
		$state = wp_filter_nohtml_kses($_POST['state']);
		add_comment_meta( $comment_id, 'state', $state ); 
	}

	if ( ( isset( $_POST['zip'] ) ) && ( $_POST['zip'] != '') ) {
		$zip = wp_filter_nohtml_kses($_POST['zip']);
		add_comment_meta( $comment_id, 'zip', $zip ); 
	}

	if ( ( isset( $_POST['request'] ) ) && ( $_POST['request'] != '') ) {
		if (is_array($_POST['request'])) {
			foreach($_POST['request'] as $value) {
				$request .= $value . ',';
			}
		} else {
			$request = $_POST['request'];
		}
		$request = wp_filter_nohtml_kses($request);
		add_comment_meta( $comment_id, 'request', $request ); 
	}

	if ( ( isset( $_POST['other'] ) ) && ( $_POST['other'] != '') ) {
		$other = wp_filter_nohtml_kses($_POST['other']);
		add_comment_meta( $comment_id, 'other', $other ); 
	}

}



// Add the filter to check if the required comment meta data has been filled or not

add_filter( 'preprocess_comment', 'verify_comment_meta_data' );
function verify_comment_meta_data( $commentdata ) {
	if ( ! isset( $_POST['phone'] ) )
	wp_die( __( 'Error: You did not add your phone number. Hit the BACK button of your Web browser and resubmit your comment with your phone number.' ) );
	return $commentdata;
}


//Add an edit option in comment edit screen  

add_action( 'add_meta_boxes_comment', 'extend_comment_add_meta_box' );
function extend_comment_add_meta_box() {
    add_meta_box( 'address', __( 'Additional Contact Fields' ), 'extend_comment_meta_box', 'comment', 'normal', 'high' );
}
 
function extend_comment_meta_box ( $comment ) {
    $phone = get_comment_meta( $comment->comment_ID, 'phone', true );
    $address = get_comment_meta( $comment->comment_ID, 'address', true );
    $city = get_comment_meta( $comment->comment_ID, 'city', true );
    $state = get_comment_meta( $comment->comment_ID, 'state', true );
    $zip = get_comment_meta( $comment->comment_ID, 'zip', true );
    $request = get_comment_meta( $comment->comment_ID, 'request', true );
    $other = get_comment_meta( $comment->comment_ID, 'other', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?>
    <p>
        <label for="phone"><?php _e( 'Phone' ); ?></label>
        <input type="text" name="phone" value="<?php echo esc_attr( $phone ); ?>" class="widefat" />
    </p>
    <p>
        <label for="address"><?php _e( 'Street Address' ); ?></label>
        <input type="text" name="address" value="<?php echo esc_attr( $address ); ?>" class="widefat" />
    </p>
    <p>
        <label for="city"><?php _e( 'City' ); ?></label>
        <input type="text" name="city" value="<?php echo esc_attr( $city ); ?>" class="widefat" />
    </p>
    <p>
        <label for="state"><?php _e( 'State' ); ?></label>
        <input type="text" name="state" value="<?php echo esc_attr( $state ); ?>" class="widefat" />
    </p>
    <p>
        <label for="zip"><?php _e( 'Zip Code' ); ?></label>
        <input type="text" name="zip" value="<?php echo esc_attr( $zip ); ?>" class="widefat" />
    </p>
    <p>
        <label for="request"><?php _e( 'Would like to:' ); ?></label>
        <input type="text" name="request" value="<?php echo esc_attr( $request ); ?>" class="widefat" />
    </p>
    <p>
        <label for="other"><?php _e( 'Other request:' ); ?></label>
        <input type="text" name="other" value="<?php echo esc_attr( $other ); ?>" class="widefat" />
    </p>

    <?php
}

// Update comment meta data from comment edit screen 

add_action( 'edit_comment', 'extend_comment_edit_metafields' );
function extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

	if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') ) : 
	$phone = wp_filter_nohtml_kses($_POST['phone']);
	update_comment_meta( $comment_id, 'phone', $phone );
	else :
	delete_comment_meta( $comment_id, 'phone');
	endif;
		
	if ( ( isset( $_POST['address'] ) ) && ( $_POST['address'] != '') ):
	$address = wp_filter_nohtml_kses($_POST['address']);
	update_comment_meta( $comment_id, 'address', $address );
	else :
	delete_comment_meta( $comment_id, 'address');
	endif;

	if ( ( isset( $_POST['city'] ) ) && ( $_POST['city'] != '') ):
	$city = wp_filter_nohtml_kses($_POST['city']);
	update_comment_meta( $comment_id, 'city', $city );
	else :
	delete_comment_meta( $comment_id, 'city');
	endif;
	
	if ( ( isset( $_POST['state'] ) ) && ( $_POST['state'] != '') ):
	$state = wp_filter_nohtml_kses($_POST['state']);
	update_comment_meta( $comment_id, 'state', $state );
	else :
	delete_comment_meta( $comment_id, 'state');
	endif;
	
	if ( ( isset( $_POST['zip'] ) ) && ( $_POST['zip'] != '') ):
	$zip = wp_filter_nohtml_kses($_POST['zip']);
	update_comment_meta( $comment_id, 'zip', $zip );
	else :
	delete_comment_meta( $comment_id, 'zip');
	endif;
	
	if ( ( isset( $_POST['request'] ) ) && ( $_POST['request'] != '') ):
	$request = wp_filter_nohtml_kses($_POST['request']);
	update_comment_meta( $comment_id, 'request', $request );
	else :
	delete_comment_meta( $comment_id, 'request');
	endif;
	
	if ( ( isset( $_POST['other'] ) ) && ( $_POST['other'] != '') ):
	$other = wp_filter_nohtml_kses($_POST['other']);
	update_comment_meta( $comment_id, 'other', $other );
	else :
	delete_comment_meta( $comment_id, 'other');
	endif;
	
}




/**
 * Notifies the moderator of the blog about a new comment that is awaiting approval.
 *
 * @since 1.0
 * @uses $wpdb
 *
 * @param int $comment_id Comment ID
 * @return bool Always returns true
 */


/**
 * Notifies the moderator of the blog about a new comment that is awaiting approval.
 *
 * @since 1.0
 * @uses $wpdb
 *
 * @param int $comment_id Comment ID
 * @return bool Always returns true
 */
function wp_notify_moderator($comment_id) {
	global $wpdb;

	if ( 0 == get_option( 'moderation_notify' ) )
		return true;

	$comment = get_comment($comment_id);
	$site_url = get_site_url();
	$phone = get_comment_meta( $comment->comment_ID, 'phone', true );
	$address = get_comment_meta( $comment->comment_ID, 'address', true );
	$city = get_comment_meta( $comment->comment_ID, 'city', true );
	$state = get_comment_meta( $comment->comment_ID, 'state', true );
	$zip = get_comment_meta( $comment->comment_ID, 'zip', true );
	$request = get_comment_meta( $comment->comment_ID, 'request', true );
	$other = get_comment_meta( $comment->comment_ID, 'other', true );

	$post = get_post($comment->comment_post_ID);
	$user = get_userdata( $post->post_author );
	// Send to the administration and to the post author if the author can modify the comment.
	$email_to = array( get_option('admin_email') );
	if ( user_can($user->ID, 'edit_comment', $comment_id) && !empty($user->user_email) && ( get_option('admin_email') != $user->user_email) )
		$email_to[] = $user->user_email;

	$comment_author_domain = @gethostbyaddr($comment->comment_author_IP);
	$comments_waiting = $wpdb->get_var("SELECT count(comment_ID) FROM $wpdb->comments WHERE comment_approved = '0'");

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	switch ($comment->comment_type)
	{
		case 'trackback':
			$notify_message  = sprintf( __('A new trackback on the post "%s" is waiting for your approval'), $post->post_title ) . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "\r\n\r\n";
			$notify_message .= sprintf( __('Website : %1$s (IP: %2$s , %3$s)'), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ) . "\r\n";
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			$notify_message .= __('Trackback excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
			break;
		case 'pingback':
			$notify_message  = sprintf( __('A new pingback on the post "%s" is waiting for your approval'), $post->post_title ) . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "\r\n\r\n";
			$notify_message .= sprintf( __('Website : %1$s (IP: %2$s , %3$s)'), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ) . "\r\n";
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			$notify_message .= __('Pingback excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
			break;
		default: //Comments
			$notify_message  = sprintf( __( 'Someone contacted us from the page "%s"' ), $post->post_title ) . "\r\n";
			$notify_message .= sprintf( __('Name : %1$s '), $comment->comment_author  ) . "\r\n";
			$notify_message .= sprintf( __('E-mail : %s'), $comment->comment_author_email ) . "\r\n";
			$notify_message .= sprintf( __('Phone  : %s'), $phone ) . "\r\n";
			$notify_message .= sprintf( __('Address  : %s'), $address ) . "\r\n";
			$notify_message .= sprintf( __('City  : %s'), $city ) . "\r\n";
			$notify_message .= sprintf( __('State  : %s'), $state ) . "\r\n";
			$notify_message .= sprintf( __('Zip  : %s'), $zip ) . "\r\n";
			$notify_message .= sprintf( __('Request  : %s'), $request ) . "\r\n";
			$notify_message .= sprintf( __('Other  : %s'), $other ) . "\r\n";
	
			$notify_message .= __('Message: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
			$notify_message .= sprintf( __('Edit this comment: %s'), $site_url . '/wp-admin/comment.php?action=editcomment&c=' . $comment_id ) . "\r\n";
			break;
	}

	/* translators: 1: blog name, 2: post title */
	$subject = sprintf( __('[%1$s] Contact from the page: "%2$s"'), $blogname, $post->post_title );
	$message_headers = '';

	$notify_message = apply_filters('comment_moderation_text', $notify_message, $comment_id);
	$subject = apply_filters('comment_moderation_subject', $subject, $comment_id);
	$message_headers = apply_filters('comment_moderation_headers', $message_headers);

	foreach ( $email_to as $email )
		@wp_mail($email, $subject, $notify_message, $message_headers);

	return true;
}


function wp_notify_postauthor( $comment_id, $comment_type = '' ) {
	$comment = get_comment( $comment_id );
	$site_url = get_site_url();
	$phone = get_comment_meta( $comment->comment_ID, 'phone', true );
	$address = get_comment_meta( $comment->comment_ID, 'address', true );
	$city = get_comment_meta( $comment->comment_ID, 'city', true );
	$state = get_comment_meta( $comment->comment_ID, 'state', true );
	$zip = get_comment_meta( $comment->comment_ID, 'zip', true );
	$request = get_comment_meta( $comment->comment_ID, 'request', true );
	$other = get_comment_meta( $comment->comment_ID, 'other', true );
	$post    = get_post( $comment->comment_post_ID );
	$author  = get_userdata( $post->post_author );

	// The comment was left by the author
	if ( $comment->user_id == $post->post_author )
		return false;

	// The author moderated a comment on his own post
	if ( $post->post_author == get_current_user_id() )
		return false;

	// If there's no email to send the comment to
	if ( '' == $author->user_email )
		return false;

	$comment_author_domain = @gethostbyaddr($comment->comment_author_IP);

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	if ( empty( $comment_type ) ) $comment_type = 'comment';

	if ('comment' == $comment_type) {
		/* translators: 1: blog name, 2: post title */
		$subject = sprintf( __('[%1$s] Contact from the page: "%2$s"'), $blogname, $post->post_title );

		$notify_message  = sprintf( __( 'Someone contacted us from the page "%s"' ), $post->post_title ) . "\r\n";
		$notify_message .= sprintf( __('Name : %1$s '), $comment->comment_author  ) . "\r\n";
		$notify_message .= sprintf( __('E-mail : %s'), $comment->comment_author_email ) . "\r\n";
		$notify_message .= sprintf( __('Phone  : %s'), $phone ) . "\r\n";
		$notify_message .= sprintf( __('Address  : %s'), $address ) . "\r\n";
		$notify_message .= sprintf( __('City  : %s'), $city ) . "\r\n";
		$notify_message .= sprintf( __('State  : %s'), $state ) . "\r\n";
		$notify_message .= sprintf( __('Zip  : %s'), $zip ) . "\r\n";
		$notify_message .= sprintf( __('Request  : %s'), $request ) . "\r\n";
		$notify_message .= sprintf( __('Other  : %s'), $other ) . "\r\n";
	
		$notify_message .= __('Message: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
		$notify_message .= sprintf( __('Edit this comment: %s'), $site_url . '/wp-admin/comment.php?action=editcomment&c=' . $comment_id ) . "\r\n";

	} elseif ('trackback' == $comment_type) {
		$notify_message  = sprintf( __( 'New trackback on your post "%s"' ), $post->post_title ) . "\r\n";
		/* translators: 1: website name, 2: author IP, 3: author domain */
		$notify_message .= sprintf( __('Website: %1$s (IP: %2$s , %3$s)'), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ) . "\r\n";
		$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
		$notify_message .= __('Excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
		$notify_message .= __('You can see all trackbacks on this post here: ') . "\r\n";
		/* translators: 1: blog name, 2: post title */
		$subject = sprintf( __('[%1$s] Trackback: "%2$s"'), $blogname, $post->post_title );
	} elseif ('pingback' == $comment_type) {
		$notify_message  = sprintf( __( 'New pingback on your post "%s"' ), $post->post_title ) . "\r\n";
		/* translators: 1: comment author, 2: author IP, 3: author domain */
		$notify_message .= sprintf( __('Website: %1$s (IP: %2$s , %3$s)'), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ) . "\r\n";
		$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
		$notify_message .= __('Excerpt: ') . "\r\n" . sprintf('[...] %s [...]', $comment->comment_content ) . "\r\n\r\n";
		$notify_message .= __('You can see all pingbacks on this post here: ') . "\r\n";
		/* translators: 1: blog name, 2: post title */
		$subject = sprintf( __('[%1$s] Pingback: "%2$s"'), $blogname, $post->post_title );
	}
	$notify_message .= sprintf( __('Edit this comment: %s'), bloginfo( $url ) . '/wp-admin/comment.php?action=editcomment&c=' . $comment_id ) . "\r\n";
	

	$wp_email = 'wordpress@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));

	if ( '' == $comment->comment_author ) {
		$from = "From: \"$blogname\" <$wp_email>";
		if ( '' != $comment->comment_author_email )
			$reply_to = "Reply-To: $comment->comment_author_email";
	} else {
		$from = "From: \"$comment->comment_author\" <$wp_email>";
		if ( '' != $comment->comment_author_email )
			$reply_to = "Reply-To: \"$comment->comment_author_email\" <$comment->comment_author_email>";
	}

	$message_headers = "$from\n"
		. "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";

	if ( isset($reply_to) )
		$message_headers .= $reply_to . "\n";

	$notify_message = apply_filters('comment_notification_text', $notify_message, $comment_id);
	$subject = apply_filters('comment_notification_subject', $subject, $comment_id);
	$message_headers = apply_filters('comment_notification_headers', $message_headers, $comment_id);

	@wp_mail( $author->user_email, $subject, $notify_message, $message_headers );

	return true;
}