<?php
/*----------------------------------------------
 Plugin Name: Content Rotator
 Plugin URI: http://cea.vnuhcm.edu.vn
 Description: Sample plugin for rotating chunks of custom content.
 Author: Than Doan Dang Khoa
 Version: 0.1
 Author URI:http://cea.vnuhcm.edu.vn
----------------------------------------------*/
// include() or require() any necessary files here...
include_once ('includes/ContentRotatorWidget.php');
include_once('includes/ContentRotator.php');

// Tie into Wordpress hooks and any functions that should run on load.
add_action('widgets_init','ContentRotatorWidget::register_this_widget');
add_action('admin_menu','ContentRotator::add_menu_item');

/* EOF */