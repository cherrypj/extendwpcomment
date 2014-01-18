<?php
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();
    
$comments = get_comments();
foreach($comments as $comment) {
	delete_comment_meta($comment->comment_ID, 'phone');
	delete_comment_meta($comment->comment_ID, 'address');
	delete_comment_meta($comment->comment_ID, 'city');
	delete_comment_meta($comment->comment_ID, 'state');
	delete_comment_meta($comment->comment_ID, 'zip');
	delete_comment_meta($comment->comment_ID, 'request');
	delete_comment_meta($comment->comment_ID, 'other');
}
