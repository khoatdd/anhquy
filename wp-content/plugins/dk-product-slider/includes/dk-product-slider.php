<?php
/**
* Dangkhoa Product Slider
*/
class DKProductSlider
{
    const admin_menu_slug = 'dk_product_slider';
    //! Public function
    /**
    * Register new post type - "product"
    */
    public static function register_post_types()
    {
        if ( post_type_exists('product') ) {
            return;
        }
        register_post_type( 'product',
            array(
                'label' => '0. Products',
                'labels' => array(
                    'name'                  => __( 'Products', 'woocommerce' ),
                            'singular_name'         => __( 'Product', 'woocommerce' ),
                            'menu_name'             => _x( 'Products', 'Admin menu name', 'woocommerce' ),
                            'add_new'               => __( 'Add Product', 'woocommerce' ),
                            'add_new_item'          => __( 'Add New Product', 'woocommerce' ),
                            'edit'                  => __( 'Edit', 'woocommerce' ),
                            'edit_item'             => __( 'Edit Product', 'woocommerce' ),
                            'new_item'              => __( 'New Product', 'woocommerce' ),
                            'view'                  => __( 'View Product', 'woocommerce' ),
                            'view_item'             => __( 'View Product', 'woocommerce' ),
                            'search_items'          => __( 'Search Products', 'woocommerce' ),
                            'not_found'             => __( 'No Products found', 'woocommerce' ),
                            'not_found_in_trash'    => __( 'No Products found in trash', 'woocommerce' ),
                            'parent'                => __( 'Parent Product', 'woocommerce' ),
                            'featured_image'        => __( 'Product Image', 'woocommerce' ),
                            'set_featured_image'    => __( 'Set product image', 'woocommerce' ),
                            'remove_featured_image' => __( 'Remove product image', 'woocommerce' ),
                            'use_featured_image'    => __( 'Use as product image', 'woocommerce' ),
                ),
                'description' => 'This is Product',
                'public' => true,
                'show_ui' => true,
                'menu_position' => 5,
                'supports' => array('title','editor','custom_fields','thumbnail','comments'),
                'taxonomies' => array('category'),
                'menu_icon'   => 'dashicons-cart',
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'show_in_admin_bar' => true,

            )
        );
    }

    /**
    * Add setting link to plugin
    */
    public static function add_plugin_settings_link($links,$file) {
        if ( $file == 'dk-product-slider/index.php')
        {
            $settings_link = sprintf('<a href="%s">%s</a>', admin_url('options-general.php?page='.self::admin_menu_slug), 'Settings');
            array_unshift($links, $settings_link);
        }
        return $links;
    }
    //------------------------------------------------------------------------

    /**
    * Print inner carousel item block
    * @param $hash array An associative array containing keys and values e.g. array('key' => 'value')
    * @return none Just print the output
    */

    public static function print_inner_carousel_item_block($active='')
    {
        $tpl1 = file_get_contents(dirname(dirname(__FILE__)).'/tpls/item-block-1.tpl');
        $tpl2 = file_get_contents(dirname(dirname(__FILE__)).'/tpls/item-block-2.tpl');
        $tpl3 = file_get_contents(dirname(dirname(__FILE__)).'/tpls/item-block-3.tpl');
        $placeholders = self::_get_items_information();
        $placeholders[0]['active'] = 'active';
        $count = count ($placeholders);
        // print '<pre>';
        // print_r($placeholders);
        // print '</pre>';
        for ($i=0; $i <= $count - 2 ; $i++) { 
            print self::parse($tpl3,$placeholders[$i]);
        }
        $countlastarray = count($placeholders[$count-1]);
        $countlastarray = round($countlastarray/3);
        $tpl = 'tpl'.$countlastarray;
        print self::parse($$tpl,$placeholders[$count-1]);
        print plugins_url('/js/wp_enqueue_scripts',dirname(__FILE__));
    }


    /**
    * Register custom script
    */
    public static function register_custom_scripts ()
    {
        wp_enqueue_script('dk-product-slider',plugins_url('/js/dk-product-slider.js',dirname(__FILE__)));
    }

    //! Private function
    /**
     *
     * A single parsing function for basic templating.
     *
     * @param $tpl string A formatting string containing [+placeholders+]
     * @param $hash array An associative array containing keys and values e.g. array('key' => 'value');
     * @return string Placeholders corresponding to the key of the hash will be replaced with the values the resulting string will be return.
     */
    private static function parse($tpl, $hash){
        foreach ($hash as $key => $value) {
            $tpl = str_replace('[+'.$key.'+]', $value, $tpl);
        }
        return $tpl;
    }

    /**
    * Get item list
    * @return $hash array
    */
    private static function _get_items_information()
    {
        $results = array();
        $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1
        );
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
          while ($my_query->have_posts()) : $my_query->the_post();
              $results[] = get_the_title();
              $results[] = get_the_post_thumbnail_url();
              $results[] = get_permalink();
          endwhile;
        }
        wp_reset_query();  // Restore global post data stomped by the_post().
        $results = self::_split_array($results);
        $results = self::_rename_array_key($results);
        // print '<pre>';
        // print_r ($results);
        // print '</pre>';
        return $results;
    }

    private static function _split_array($array)
    {
        $array_length = count($array);
        $split_array = array();
        $j = 0;
        $split_count = 0;
        for ($i=0; $i < $array_length ; $i++) { 
            if ($j == 0) {
                $slpit_array[$split_count] = array();
            }
            $split_array[$split_count][] = $array[$i];
            $j++;
            if ($j == 9) {
                $j = 0;
                $split_count++;
            }
        }
        return $split_array;
    }

    private static function _rename_array_key($array)
    {
        $array_length = count($array);
        $results = array(array());
        for ($i=0; $i <= $array_length - 1 ; $i++) { 
            $results[$i]['title-1'] = $array[$i][0];
            $results[$i]['featured-img-1'] = $array[$i][1];
            $results[$i]['permalink-1'] = $array[$i][2];
            if (count($array[$i]) > 3) {
                $results[$i]['title-2'] = $array[$i][3];
                $results[$i]['featured-img-2'] = $array[$i][4];
                $results[$i]['permalink-2'] = $array[$i][5];
            }
            if (count($array[$i]) > 6) {
                $results[$i]['title-3'] = $array[$i][6];
                $results[$i]['featured-img-3'] = $array[$i][7];
                $results[$i]['permalink-3'] = $array[$i][8];
            }
        }
        return $results;
    }
}