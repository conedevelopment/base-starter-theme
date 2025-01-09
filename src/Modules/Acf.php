<?php

namespace Base\Modules;

class Acf extends Module
{
    public static function checkAcf() {
        if (!class_exists('ACF') && !is_admin()) {
            echo '<style>
                body {
                    margin: 0;
                }

                .acf-warning {
                    align-items: center;
                    background-color: hsl(0deg 0% 97%);
                    font-family: Seravek, "Gill Sans Nova", Ubuntu, Calibri, "DejaVu Sans", source-sans-pro, sans-serif;
                    gap: 2rem;
                    min-block-size: 100dvh;
                    display: flex;
                    justify-content: center;
                    padding: 1rem;
                }

                .acf-warning__logo {
                    display: flex;
                }

                .acf-warning__logo svg {
                    block-size: 1.5rem;
                    inline-size: auto;
                }

                .acf-warning__caption {
                    border-inline-start: 1px solid hsl(0deg 0% 90%);
                    color: hsl(0deg 0% 25%);
                    font-size: clamp(1rem, 0.5rem + 2vw, 1.15rem);
                    margin-block: 0;
                    max-inline-size: 50ch;
                    padding-inline-start: 2rem;
                }
            </style>';
            echo '<div class="acf-warning">
                    <a class="acf-warning__logo" href="https://github.com/conedevelopment/base-starter-theme" aria-label="Base">
                        ' . base_get_inline_svg_asset('base-logo.svg') . '
                    </a>
                    <p class="acf-warning__caption">Warning: <strong>Advanced Custom Fields (Pro)</strong> plugin is not active! <br> Please activate it to ensure proper functionality.</p>
                </div>';
            exit;
        }
    }

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
        add_action('after_setup_theme', [static::class, 'checkAcf']);
        add_action('acf/init', [static::class, 'removeAutoP'], 12);
        add_filter('acf/admin/prevent_escaped_html_notice', '__return_true');

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

        /**
         * Modify ACF CPT save folder
         */
        add_filter('acf/settings/save_json/type=acf-post-type', function($path) {
            return get_template_directory() . '/acf-json-cpt';
        });
    }
}
