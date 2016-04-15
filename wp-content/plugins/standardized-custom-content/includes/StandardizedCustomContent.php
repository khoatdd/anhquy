<?php

/**
 * StandardizedCustomContent
 *
 * A class designed to standardize Wordpress' custom fields and allow for checkboxs, dropdowns, etc.
 */
class StandardizedCustomContent
{
    /**
     * Which types of content do we want to standardize? Here you can list WP built-in content type e.g. 'page', 'post', or any custom post-types you define.
     */
    public static $content_types_array = array('post');

    /*------------------------------------------------------------------------------
    public static $custom_fields = array(
        array(
            // name and id of the form element & as the meta_key in the wp_postmeta table. Should contain lowercase letters, "-", and "-" only. Names beginning with "_" will be hidden from built-in WP functions, e.g. the_meta()
            'name' => 'my_name',
            // used in the element's <label>
            'title' => 'This is the bold Text that appear above the Form element!',
            // optional text will be wrapped in a <p> and appear below the element
            'description' => 'Shh... this is extra italic text',
            // one of the supported element types: checkbox, dropdown, text, textarea, wysiwyg
            'type' => 'dropdown',
            // Include this ONLY when type = dropdown!!
            'options' => array('one', 'two', 'three'),
        ),
    );
    ------------------------------------------------------------------------------*/
    /**
     * The prefix helps ensure unique keys in the $_POST array by appending this prefix to your field name. E.g. if your
     * prefix is 'my_' and your field name from the $custom_fields_for_posts array is 'field' then your form element gets
     * generated something like <input name="my_field"/>
     * This prefix is NOT used as part of the meta_key when saving the field names to database. If you want your fields
     * to be hidden from built-in Wordpress theme functions, you can name them individually using an underscore "_" as
     * the first character
     * If you omit a prefix entirely, your custom field names must steer clear of the built-in post field names (e.g. 'content').
     */
    public static $prefix = 'custom_content_';

    //-----------------------------------------------------------------------------
    public static $custom_fields_for_posts = array(
        array(
            'name' => 'my_text',
            'title' => 'Simple text input',
            'description' => '',
            'type' => 'text',
        ),
        array(
            'name' => 'short_text',
            'title' => 'A short bit of text',
            'description' => 'This is a textarea, without any formatting controls.',
            'type' => 'textarea',
            'value' => 'normal text',
        ),
        array(
            'name' => 'gender',
            'title' => 'Gender',
            'description' => 'Sample dropdown menu',
            'type' => 'dropdown',
            'options' => array('Male', 'Female'),
        ),
        array(
            'name' => 'formatted_text',
            'title' => 'Formatted Text',
            'description' => 'This uses jQuery to add the formatting controls.',
            'type' => 'wysiwyg',
        ),
        array(
            'name' => 'my_checkbox',
            'title' => 'Do You Like This Checkbox?',
            'description' => 'Checkboxes are tricky... they either have a value, or they are null.',
            'type' => 'checkbox',
        )
    );

    //! Private functions

    /**
     * Create the new Custom Fields box.
     */
    public static function create_meta_box()
    {
        $content_types_array = self::_get_active_content_type();
        foreach ($content_types_array as $content_type) {
            add_meta_box
            (
                'my-custom_field',
                'Custom Fields',
                'StandardizedCustomContent::print_custom_fields',
                $content_type,
                'normal',
                'high',
                $content_type
            );
        }
    }

    /**
     * This plugin is meant to be configured so it acts on a specified list of content types, e.g. post, page, or any custom content types that are registered.
     * FUTURE: read this from the database
     * @return array Array of strings, each string bring the name of a WP post-type
     */
    private static function _get_active_content_type()
    {
        return self::$content_types_array;
    }

    public static function print_custom_fields($post, $callback_args = '')
    {
        $content_type = $callback_args['args']; // the 7th arg from add_meta_box()
        $custom_fields = self::_get_custom_fields($content_type);
        $output = '';
        foreach ($custom_fields as $field) {
            $output_this_field = '';
            print_r($field['name']);
            $field['value'] = htmlspecialchars(get_post_meta($post->ID, $field['name'], true));
            print_r(get_post_meta($post->ID, $field['name'], false));
            $field['name'] = self::$prefix . $field['name']; // this ensures unique keys in $_POST
            switch ($field['type']) {
                case 'checkbox':
                    $output_this_field .= self::_get_checkbox_element($field);
                    break;
                case 'dropdown':
                    $output_this_field .= self::_get_dropdown_element($field);
                    break;
                case 'textarea':
                    $output_this_field .= self::_get_textarea_element($field);
                    break;
                case 'wysiwyg':
                    $output_this_field .= self::_get_wysiwyg_element($field);
                    break;
                case 'text':
                default:
                    $output_this_field .= self::_get_text_element($field);;
                    break;
            }
            // optionally add description
            if ($field['description']) {
                $output_this_field .= '<p>' . $field['description'] . '</p>';
            }
            $output .= '<div class="form-field form-required">' . $output_this_field . '</div>';
        }
        // Print the form
        print '<div class="form-wrap">';
        wp_nonce_field('update_custom_content_fields', 'custom_content_fields_nonce');
        print $output;
        print '</div>';
    }

    /**
     * Get custom fields for the content type specified.
     *
     * FUTURE: read these arrays from the database.
     *
     * @param string $content_type The name of the content type, e.g. post, page.
     * @return mixed array of associative array defining custom fields to use for the content_type specified.
     */
    private static function _get_custom_fields($content_type)
    {
        return self::$custom_fields_for_posts;
    }

    //------------------------------------------------------------------------------

    /**
     * The following '_get_xxx_element' functions each generate a single form element
     * @param array $data contains an associative array describing how the element should look with keys for name, title, description, and type.
     * @return string an HTML form element
     * Note: the checked value is hard-coded to 'yes' for simplicity.
     */
    private static function _get_checkbox_element($data)
    {
        $tpl = '<input type="checkbox" name="[+name+]" id="[+name+]" value="yes" [+is_checked+] style="width:auto"/>
                <label for"[+name+]" style="display:inline"><strong>[+title+]</strong></label>';
        // Special handling to see if the box is checked.
        if ($data['value'] == 'yes') {
            $data['is_checked'] = 'checked="checked"';
        } else {
            $data['is_checked'] = '';
        }
        return self::parse($tpl, $data);
    }

    //------------------------------------------------------------------------------

    /**
     *
     * A single parsing function for basic templating.
     *
     * @param $tpl string A formatting string containing [+placeholders+]
     * @param $hash array An associative array containing keys and values e.g. array('key' => 'value');
     * @return string Placeholders corresponding to the key of the hash will be replaced with the values the resulting string will be return.
     */
    function parse($tpl, $hash)
    {
        foreach ($hash as $key => $value) {
            $tpl = str_replace('[+' . $key . '+]', $value, $tpl);
        }
        return $tpl;
    }

    //------------------------------------------------------------------------------

    /**
     * The dropdown is special: it requires that you supply an array of options in its 'option' key.
     * The $tpl used internally here uses a custom [+option+] placeholder
     */
    private static function _get_dropdown_element($data)
    {
        // Some error messaging.
        if (!isset($data['options']) || !is_array($data['options'])) {
            return '<p><strong>Custom Content Error:</strong> No options supplies for ' . $data['name'] . '</p>';
        }
        $tpl = '<label for="[+name+]"><strong>[+title+]</strong></label><br/>
                <select name="[+name+]" id="[+name+]">
                    [+options+]
                </select>';
        $option_str = '<option value="" selected="selected">Pick one</option>';
        foreach ($data['options'] as $option) {
            $option = htmlspecialchars($option); // Filter the values
            $is_selected = '';
            if ($data['value'] == $option) {
                $is_selected = 'selected = "selected"';
            }
            $option_str .= '<option value="' . $option . '"' . $is_selected . '>' . $option . '</option>';
        }
        unset($data['options']); // The parse function req's a simple hash
        $data['options'] = $option_str;
        return self::parse($tpl, $data);
    }
    //! Public function

    private static function _get_textarea_element($data)
    {
        $tpl = '<label for="[+name+]"><strong>[+title+]</strong></label><br/>
			<textarea name="[+name+]" id="[+name+]" columns="30" rows="3">[+value+]</textarea>';
        return self::parse($tpl, $data);
    }

    private static function _get_wysiwyg_element($data)
    {
        $tpl = '<label for="[+name+]"><strong>[+title+]</strong></label>
			<textarea name="[+name+]" id="[+name+]" columns="30" rows="3">[+value+]</textarea>
			<script type="text/javascript">
				jQuery( document ).ready( function() {
					jQuery( "[+name+]" ).addClass( "mceEditor" );
					if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
						tinyMCE.execCommand( "mceAddControl", false, "[+name+]" );
					}
				});
			</script>
			';
        return self::parse($tpl, $data);
    }

    private static function _get_text_element($data)
    {
        $tpl = '<label for="[+name+]"><strong>[+title+]</strong></label><br/>
				<input type="text" name="[+name+]" id="[+name+]" value="[+value+]" /><br/>';
        return self::parse($tpl, $data);
    }

    /**
     * Remove the default Custom Fields meta box. Only affects the content types that have been activated. All inputs are sent by WP.
     * @param string $type The name of the post-type being edited, e.g. 'post
     * @param string $context Identifies a type of meta-box, e.g. 'normal', 'advanced', 'side'
     * @param object $post The current post, with attributes e.g. $post->ID and $post->post_name
     */

    public static function remove_default_custom_fields($type, $context, $post)
    {
        $content_types_array = self::_get_active_content_type();
        foreach (array('normal', 'advanced', 'side') as $context) {
            foreach ($content_types_array as $content_type) {
                remove_meta_box('postcustom', $content_type, $context);
            }
        }
    }

    /*------------------------------------------------------------------------------
    Save the new Custom Fields values
    INPUT:
        $post_id (int) id of the post these custom fields are associated with
        $post (obj) the post object
    ------------------------------------------------------------------------------*/
    public static function save_custom_fields($post_id, $post)
    {
        // The 2nd arg here is important because there are multiple nonces on the page
        if (!empty($_POST) && check_admin_referer('update_custom_content_fields', 'custom_content_fields_nonce')) {
            $custom_fields = self::_get_custom_fields($post->post_type);

            foreach ($custom_fields as $field) {
                if (isset($_POST[self::$prefix . $field['name']])) {
                    $value = trim($_POST[self::$prefix . $field['name']]);
                    // Auto-paragraphs for any WYSIWYG
                    if ($field['type'] == 'wysiwyg') {
                        $value = wpautop($value);
                    }
                    update_post_meta($post_id, $field['name'], $value);
                } // if not set, then it's an unchecked checkbox, so blank out the value.
                else {
                    update_post_meta($post_id, $field['name'], '');
                }
            }

        }
    }
}
/* EOF */