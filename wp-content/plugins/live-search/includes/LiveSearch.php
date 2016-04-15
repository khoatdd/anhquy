<?php
/**
*class LiveSearch
*
* Adds basic Ajax functionality to the built-in Wordpress search
* Widget: it displays results matching your query without the user having to submit the form
*/
class LiveSearch
{
	const plugin_name = 'Live Search';
	const min_php_version = '5.2';
	/**
	* Adds the necessary JavaScript and/or CSS to the pages to enable the Ajax search.
	*/
	/**
	*
	* Prints some Javascript into the document head. We are printing directly to the document head because we need our Javascript to contain a dynamic value that indentifies the search handler script.
	* @return none This does, however, create some HTML output
	*/
	public static function head() {
		if (self::_is_searchable_page()) {
			$search_handler_url = plugins_url('ajax_search_results.php',dirname(__FILE__));
			include('dynamic_javascript.php');
		}
	}
	/**
	* The main function for this plugin, similar to __construct()
	*/
	public static function initialize() {
		Test::min_php_version(self::min_php_version,self::plugin_name);
		if (self::_is_searchable_page()) {
			wp_enqueue_script('jquery');// make sure jQuery is loaded! Otherwise our JS will fail!
			$src = plugins_url('css/live-search.css',dirname(__FILE__));
			wp_register_style('live-search',$src);
			wp_enqueue_style('live-search');
		}
	}
	/**
	* _is_searchable_page
	*
	* Any page that's not in the WP admin area is considered searchable
	* @return boolean Simple true/false as to whether the current page is _is_searchable_page.
	*/
	private static function _is_searchable_page() {
		if (is_admin()) {
			return false;
		} else {
			return true;
		}
	}
}

/* EOF */