<?php

namespace Base\Modules;

use Base\Support\Str;

class Shortcodes extends Module
{
    /**
     * Iframe embed.
     *
     * @return string
     */
    public static function iframe($atts, $content = null): string
    {
        $atts = shortcode_atts([
            'type' => 'youtube',
            'message' => __('In order to play embedded YouTube videos, you must agree to the processing of data and the use of associated cookies.', 'base'),
            'btn-on-text' => __('Decline YouTube cookies', 'base'),
            'btn-off-text' => __('Allow YouTube cookies', 'base'),
        ], $atts);

        if ($content) {
            $content = str_replace('src="', 'data-src="', $content);
        }

        return '<div class="restriction" data-type="' . $atts['type'] . '">
                    <div class="restriction__caption">
                        <img class="restriction__icon" src="' . get_template_directory_uri() . '/assets/img/privacy.svg" alt="">
                        <div class="restriction__body">
                            <p>' . $atts['message'] . '</p>
                            <button class="js-sub-cookie-access btn btn--primary" data-type="' . $atts['type'] . '" data-on-text="' . $atts['btn-on-text'] . '" data-off-text="' . $atts['btn-off-text'] . '"></button>
                        </div>
                    </div>
                    ' . $content . '
                </div>';
    }

    /**
     * Responsive table shortcode.
     */
    public static function table($atts, $content = null): string
    {
        return '<div class="table-responsive">' . Str::removeEmptyP($content) . '</div>';
    }

    /**
     * Button shortcode.
     */
    public static function button($atts, $content = null): string
    {
        $atts = shortcode_atts([
            'url' => '',
            'type' => 'secondary',
            'target' => '_self'
        ], $atts);

        return '<a class="btn btn--' . $atts['type'] . '" href="' . $atts['url'] . '" target="' . $atts['target'] . '">' . $content . '</a>';
    }

    /**
     * Cookie opt in-out btn shortcode.
     */
    public static function cookie($atts, $content = null): string
    {
        $args = wp_parse_args(shortcode_atts([
            'type' => 'none',
        ], $atts));

        return '<div class="cookie-acceptance"><button class="js-sub-cookie-access btn btn--primary" data-type="' . $args['type'] . '" data-on-text="' .  __('Decline', 'base') . '" data-off-text="' .  __('Allow', 'base') . '">' . $content . '</button></div>';
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_shortcode('table', [static::class, 'table']);
        add_shortcode('button', [static::class, 'button']);
        add_shortcode('cookie-button', [static::class, 'cookie']);
        add_shortcode('iframe', [static::class, 'iframe']);
    }
}
