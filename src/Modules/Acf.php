<?php

namespace Base\Modules;

class Acf extends Module
{
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

        /**
         * Add ACF related custom CSS
         */
        add_action('admin_head', function () {
            echo '<style id="custom-acf">
                .mce-menu .mce-menu-item.mce-active.mce-menu-item-normal span,
                .mce-menu .mce-menu-item.mce-active.mce-menu-item-preview span,
                .mce-menu .mce-menu-item.mce-selected span,
                .mce-menu .mce-menu-item:focus span,
                .mce-menu .mce-menu-item:hover span {
                    color: #fff !important;
                }
                .acf-tab-wrap {
                    overflow: visible !important;
                }
                .acf-field-image .image-wrap {
                    max-width: 250px !important;
                }
                .field-disabled nput {
                    opacity: 50%;
                    pointer-events: none;
                }
                .acf-clean-group > .acf-label {
                    display: none;
                }
                .acf-clean-group > .acf-input > .acf-fields {
                    border: 0;
                }
                .acf-clean-group > .acf-input > .acf-fields > .acf-field {
                    border: 0;
                    padding: 0;
                }
                .acf-clean-group > .acf-input > .acf-fields > .acf-field + .acf-field {
                    margin-block-start: 0.5rem;
                }
            </style>';
        });
    }
}
