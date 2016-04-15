<?php 
if ( ! function_exists( 'machenic_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function machenic_theme_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on machenic_theme, use a find and replace
	 * to change 'machenic_theme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'machenic_theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
//	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'machenic_theme' ),
		'social'  => __( 'Social Links Menu', 'machenic_theme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$default_background = array(
  			'default-color' => '#e8e8e8',
  		);
	add_theme_support( 'custom-background', $default_background );
	/**
	 * Add theme logo support
	 */
	add_theme_support('site-logo');
}
endif; // machenic_theme_setup
add_action( 'after_setup_theme', 'machenic_theme_setup' );

class Machenic_Nav_Walker extends Walker_Nav_Menu {
 
 //Overwrite display_element function to add has_children attribute. Not needed in >= Wordpress 3.4
		/**
		 * @link https://gist.github.com/duanecilliers/1817371 copy from this url
		 */
		function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
		{
			if (!$element)
				return;
			$id_field = $this->db_fields['id'];

			//display this element
			if (is_array($args[0]))
				$args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
			else if (is_object($args[0]))
				$args[0]->has_children = !empty($children_elements[$element->$id_field]);
			$cb_args = array_merge(array(&$output, $element, $depth), $args);
			call_user_func_array(array(&$this, 'start_el'), $cb_args);

			$id = $element->$id_field;

			// descend only when the depth is right and there are childrens for this element
			if (($max_depth == 0 || $max_depth > $depth + 1) && isset($children_elements[$id])) {

				foreach ($children_elements[$id] as $child) {

					if (!isset($newlevel)) {
						$newlevel = true;
						//start the child delimiter
						$cb_args = array_merge(array(&$output, $depth), $args);
						call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
					}
					$this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
				}
				unset($children_elements[$id]);
			}

			if (isset($newlevel) && $newlevel) {
				//end the child delimiter
				$cb_args = array_merge(array(&$output, $depth), $args);
				call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
			}

			//end this element
			$cb_args = array_merge(array(&$output, $element, $depth), $args);
			call_user_func_array(array(&$this, 'end_el'), $cb_args);
		}// display_element


		/**
		 * @link https://gist.github.com/duanecilliers/1817371 copy from this url
		 */
		public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) 
		{
			if ((is_object($item) && $item->title == null) || (!is_object($item))) {
				return ;
			}

			$indent = ($depth) ? str_repeat("\t", $depth) : '';

			$li_attributes = '';
			$class_names = $value = '';

			$classes = empty($item->classes) ? array() : (array) $item->classes;
			//Add class and attribute to LI element that contains a submenu UL.
			if (is_object($args) && $args->has_children) {
				//$classes[] = 'dropdown';
				$li_attributes .= ' data-dropdown="dropdown"';
			}
			$classes[] = 'menu-item-' . $item->ID;
			//If we are on the current page, add the active class to that menu item.
			$classes[] = ($item->current) ? 'active' : '';

			//Make sure you still add all of the WordPress classes.
			$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
			$class_names = ' class="' . esc_attr($class_names) . '"';

			$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
			$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

			//Add attributes to link element.
			$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
			$attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
			$attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
			$attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
			$attributes .= (is_object($args) && $args->has_children) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

			$item_output = (is_object($args)) ? $args->before : '';
			$item_output .= '<a' . $attributes . '>';
			$item_output .= (is_object($args) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (is_object($args) ? $args->link_after : '');
			$item_output .= (is_object($args) && $args->has_children) ? ' <span class="caret"></span> ' : '';
			$item_output .= '</a>';
			$item_output .= (is_object($args) ? $args->after : '');

			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}// start_el


		public function start_lvl(&$output, $depth = 0, $args = array()) 
		{
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"sub-menu dropdown-menu\">\n";
		}
} // end Machenic_Nav_Walker

add_action( 'wp_enqueue_scripts', 'register_my_custom_style' );
/* Add custom CSS to theme */
function register_my_custom_style()
{
	$CSS_Url = get_template_directory_uri().'/css/custom.css';
	wp_register_style('customcss',$CSS_Url);
	wp_enqueue_style('customcss');
}

/*
 * Add scripts to theme
 */
if (!is_admin()) { add_action('wp_footer','register_theme_script');}
function register_theme_script()
{
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery',get_template_directory_uri().'/js/jquery.js');
	wp_enqueue_script('bootstrap',get_template_directory_uri().'/js/bootstrap.min.js');
	wp_enqueue_script('prettyPhoto',get_template_directory_uri().'/js/jquery.prettyPhoto.js');
	wp_enqueue_script('main',get_template_directory_uri().'/js/main.js');
}

/**
 * Custom template tags for this theme.
 *
 */
require get_template_directory() . '/includes/template-tags.php';
require get_template_directory() . '/includes/custom-walker-comment.php';

add_filter('comment_reply_link', 'replace_reply_link_class');
function replace_reply_link_class($class){
	if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) { }
	else
	{
		$class = str_replace("class='comment-reply-link", "class='comment-reply-link pull-right", $class);
		$class = str_replace("Reply", "<i class=\"icon-repeat\"></i> Reply", $class);
	}
	return $class;
}
add_filter('get_avatar', 'replace_avatar_class');
function replace_avatar_class($class){
	$class = str_replace("class='avatar", "class='avatar img-circle", $class);
	return $class;
}