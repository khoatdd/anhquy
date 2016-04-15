<?php
/**
 * ContentRotator
 *
 * Helper functions that assist the ContentRotatorWidget class
 */
class ContentRotator {
    /**
     * Adds a menu item inside the Wordpress admin
     */
    static function add_menu_item()
    {
        add_submenu_page(
            'plugins.php',
            'Content Rotator Configuration', // Page title
            'Content Rotator', // Menu title
            'manage_options', // permissions
            'content-rotation', // page-name (used in the URL)
            'ContentRotator::generate_admin_page' // clicking callback function
        );
    }
    /**
     * Controller that generate admin page
     */
    static function generate_admin_page()
    {
        $msg = ''; // used to display a success message on updates
        if (!empty($_POST) && check_admin_referer('content_rotation_admin_options_update','content_rotation_admin_nonce'))
        {
            update_option('content_rotation_content_separator',stripslashes($_POST['separator']));
            update_option('content_rotation_content_block',stripslashes($_POST['content_block']));
            $msg = '<div class="updated"><p>Your settings have been <strong>updated</strong></p></div>';
        }
        include('admin_page.php');
    }
    /**
     * Fetch and return a piece of random content
     */
    static function get_random_content()
    {
        $separator = get_option('content_rotation_content_separator');
        $content_block = get_option('content_rotation_content_block');
        // Ensure that the user has entered valid settings
        if (empty($content_block))
        {
            return '';
        }
        elseif (empty($separator))
        {
            return  $content_block;
        }

        // Get an array of non-empty chunks
        $content_array = explode($separator, $content_block);
        $sanitized_array = array();
        foreach ($content_array as $chunk) {
            $chunk = trim($chunk);
            if (!empty($chunk))
            {
                $sanitized_array[] = $chunk;
            }
        }
        $chunk_cnt = count($sanitized_array);
        if ($chunk_cnt)
        {
            $n = rand(0, ($chunk_cnt - 1));
            return $sanitized_array[$n];
        }
        else
        {
            return '';
        }
    }
    /**
     *
     * A single parsing function for basic templating.
     *
     * @param $tpl string A formatting string containing [+placeholders+]
     * @param $hash array An associative array containing keys and values e.g. array('key' => 'value');
     * @return string Placeholders corresponding to the key of the hash will be replaced with the values the resulting string will be return.
     */
    function parse($tpl, $hash){
        foreach ($hash as $key => $value) {
            $tpl = str_replace('[+'.$key.'+]', $value, $tpl);
        }
        return $tpl;
    }
}