<?php

namespace Base\Modules;

class Acf extends Module
{
    /**
     * Remove wpautop from ACF the_content.
     */
    public static function removeAutoP(): void
    {
        remove_filter('the_content', 'wpautop');
        remove_filter('acf_the_content', 'wpautop');

        add_filter('acf_the_content', 'wpautop', 8);
        add_filter('the_content', 'wpautop', 8);
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_filter('acf/format_value/type=wysiwyg', function ($value, $post_id, $field) {
            return wp_kses_post($value);
        }, 10, 3);

        add_filter('acf/format_value/type=textarea', function ($value, $post_id, $field) {
            if (
                in_array($field['key'], [])
            ) {
                return $value;
            }

            return esc_textarea($value);
        }, 10, 3);

        add_filter('acf/format_value/type=url', function ($value, $post_id, $field) {
            return esc_url($value);
        }, 10, 3);

        add_filter('acf/format_value/type=text', function ($value, $post_id, $field) {
            if (
                in_array($field['key'], [])
            ) {
                return $value;
            }

            return esc_html($value);
        }, 10, 3);

        add_filter('acf/settings/save_json', function ($path) {
            return get_template_directory() . '/acf-json';
        });

        add_filter('acf/settings/load_json', function ($path) {
            return get_template_directory() . '/acf-json';
        });

        add_filter('acf/admin/prevent_escaped_html_notice', '__return_true');

        /**
         * Modify ACF CPT save folder
         */
        add_filter('acf/settings/save_json/type=acf-post-type', function($path) {
            return get_template_directory() . '/acf-json-cpt';
        });

        add_action('acf/init', [static::class, 'removeAutoP'], 12);
    }
}
