<?php
/*---------------------------------------------------------------------------------
Plugin Name: Live Search
Plugin URI: http://cea.vnuhcm.edu.vn
Description: Sample plugin for integrating jQuery with your Wordpress plugins.
Author: Than Doan Dang Khoa
Version: 0.1
Author URI: http://cea.vnuhcm.edu.vn
---------------------------------------------------------------------------------*/
// include() or require() any necessary files here...
include_once('includes/LiveSearch.php');
include_once('tests/Test.php');
// Tie into Wordpress Hooks and any functions that should run on load.
add_action('init', 'LiveSearch::initialize');
add_action('wp_head', 'LiveSearch::head');
/* EOF */