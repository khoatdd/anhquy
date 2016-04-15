<?php
/**
 * ContentChunks
 */
class ContentChunks
{
    const default_shortcode_name = 'get-chunk';
    const option_key = 'content_chunks_shortcode';
    // Used to uniquely identify this plugin's menu page in the WP manager
    const admin_menu_slug = 'content_chunks';
    public static function register_chunk_post_type()
    {
        register_post_type( 'chunk',
            array(
                'label' => 'Chunks',
                'labels' => array(
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Chunk',
                    'edit_item' => 'Edit Chunk',
                    'new_item' => 'New Chunk',
                    'view_item' => 'View Chunk',
                    'search_items' => 'Search Chunks',
                    'not_found' => 'No chunks Found',
                    'not_found_in_trash'=> 'Not Found in Trash',
                ),
                'description' => 'Reusable chunks of content',
                'public' => false,
                'show_ui' => true,
                'menu_position' => 5,
                'supports' => array('title','editor','custom_fields','thumbnails'),
            )
        );
    }
    /**
     * Register the shortcodes used
     */
    public static function register_shortcodes()
    {
        $shortcode = get_option(self::option_key, self::default_shortcode_name);
        add_shortcode($shortcode,'ContentChunks::get_chunk');
    }
    /**
     * Return the content of a chunk, referenced via shortcode, e.g. put the following in the content of a post or page: [get-chunk title="my_title"]
     *
     * @param array $raw_args Any arguments included in the shortcode.
     * E.g. [get-chunk x="1" y="2"] translates to array('x'=>1,'y'=>'2')
     * @param string $content Optional content if the shortcode encloses content with a closing tag, e.g. [get-chunk]My content here[get-chunk]
     * @return string The text that should replace the shortcode
     */
    public static function get_chunk($raw_args,$content = null)
    {
        $defaults = array('title' => '');
        $sanitized_args = shortcode_atts($defaults, $raw_args);
        if (empty($sanitized_args['title']))
        {
            return '';
        }
        $result = get_page_by_title($sanitized_args['title'],'OBJECT','chunk');
        if ($result)
        {
            return $result->post_content;
        }
    }

    /**
     * Create custom post-type menu
     */
    public static function create_admin_menu()
    {
        add_menu_page(
            'Content Chunks', //page title
            'Content Chunks', //menu title
            'manage_options', //capability
            self::admin_menu_slug, //menu slug
            'ContentChunks::get_admin_page' //Callback
        );
    }

    /**
     * Prints the administration page for this plugin.
     */
    public static function get_admin_page()
    {
        if (!empty($_POST) && check_admin_referer('content_chunks_options_update','content_chunks_admin_nonce'))
        {
            update_option(self::option_key,stripslashes($_POST['shortcode_name']));
            $msg = '<div class="updated"><p>Your settings have been<strong> updated</strong></p></div>';
        }
        $shortcode_name = esc_attr(get_option(self::option_key,self::default_shortcode_name));
        include('admin_page.php');
    }

    /**
     * The inputs here come directly from Wordpress:
     * @param array $links - a hash in the format of name => translation e.g. array('deactivate' => 'Deactivate') that describes all links available to a plugin
     * @param string $file - the path to plugin's main file (the one with the info header relative to the plugins directory, e.g. 'content-chunks/index.php'
     * @return array The $links hash.
     */
    public static function add_plugin_settings_link($links,$file) {
        if ( $file == 'content-chunks/index.php')
        {
            $settings_link = sprintf('<a href="%s">%s</a>', admin_url('options-general.php?page='.self::admin_menu_slug), 'Settings');
            array_unshift($links, $settings_link);
        }
        return $links;
    }
}
/* EOF */