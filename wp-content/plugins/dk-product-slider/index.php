<?php
/*----------------------------------------------
 Plugin Name: DangKhoa Product Slider
 Plugin URI: http://cea.vnuhcm.edu.vn
 Description: Create product slider on the front end
 Author: Than Doan Dang Khoa
 Version: 0.1
 Author URI:http://cea.vnuhcm.edu.vn
----------------------------------------------*/
// include() or require() any necessary files here...
include_once ('includes/dk-product-slider.php');
// Tie into Wordpress hooks and any functions that should run on load.
add_action( 'init', 'DKProductSlider::register_post_types');
add_filter('plugin_action_links', 'DKProductSlider::add_plugin_settings_link', 10, 2 );
add_action('wp_footer','DKProductSlider::register_custom_scripts',11,3);
//add_action('admin_menu','DKProductSlider::add_menu_item');

/* EOF */