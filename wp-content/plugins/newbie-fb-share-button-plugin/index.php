<?php
/*
	Plugin Name: Yurnero Facebook share button
	Plugin URI: http://www.cea.vnuhcm.edu.vn
	Description: This is a newbie plugin just to add facebook share to posts.
	Author: Than Doan Dang Khoa _ Yurnero
	Version: 0.1
	Author URI: https://www.facebook.com/than.dangkhoa
*/

// include() or require() any necessary files here...

// Setting and/or Configuration detail goes here...
// define('FB_SHARE_BUTTON_TEMPLATE','
// 	<a id="plugin-fb" href="%s" class="facebook-get-code">themecircle</a>');
define('FB_SHARE_BUTTON_TEMPLATE','
	<div class="fb-like" data-href="%s" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>');
// Tie into Wordpress Hooks and any function that should run on load.

add_filter('the_content','fb_share_get_button');
add_action('init', 'fb_share_add_js_to_doc_head');
// Private internal functions named with a leading underscored

function _fb_share_get_post_description() {}
function _fb_share_get_post_media_type() {}
function _fb_share_get_post_title() {}
function _fb_share_get_post_topic() {}
/**
* Get the URL of the current post
*
* @return  string  the URL of the current post
*/
function _fb_share_get_post_url() {
	global $post;
	print_r($post);
	return get_permalink();
}

// The "Public" functions

function fb_share_add_js_to_doc_head() {
	$src = plugins_url('fb-share.js', __FILE__ );
	wp_register_script('fb-share',$src);
	wp_enqueue_script('fb-share');
}
function fb_share_check_wordpress_version() {}
// [...]
/**
*Adds a "Facebook share" button to the post content
*
* @param string $content the existing post content
* @return string $content appends a Facebook share button to the incoming $content.
*/
function fb_share_get_button($content) {
	$url = _fb_share_get_post_url();
	$content.= _fb_share_get_post_url();
	$content.= '<br>'.$url;
	$content.- sprintf($url);
	// $content.='<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Ftest.com&amp;layout=button_count&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp" style="overflow:hidden;width:100%;height:80px;" scrolling="no" frameborder="0" allowTransparency="true">';
	$content.= sprintf(FB_SHARE_BUTTON_TEMPLATE,$url);
	// $content.= '</iframe>';
	return $content;
}

/* EOF */
