<?php

namespace Base\Modules;

use Base\Modules\Config;

class Preload extends Module
{
    /**
     * Inject preload links into the wp_head.
     */
    public static function injectPreloadLinks(): void
    {
        $preloadLinks = [
            [
                'href' => get_template_directory_uri() . '/assets/font/work-sans-v19-latin-regular.woff2',
            ],
            [
                'href' => get_template_directory_uri() . '/assets/font/work-sans-v19-latin-300.woff2',
            ],
            [
                'href' => get_template_directory_uri() . '/assets/font/work-sans-v19-latin-500.woff2',
            ],
        ];

        foreach ($preloadLinks as $link) {
            $rel = $link['rel'] ?? 'preload';
            $as = $link['as'] ?? 'font';
            $type = $link['type'] ?? 'font/woff2';
            $href = $link['href'] ?? '';
            $crossorigin = $link['crossorigin'] ?? '';

            if (!empty($href)) {
                printf(
                    '<link rel="%s" as="%s" type="%s" href="%s" %s>',
                    esc_attr($rel),
                    esc_attr($as),
                    esc_attr($type),
                    esc_url($href),
                    !empty($crossorigin) ? 'crossorigin="' . esc_attr($crossorigin) . '"' : ''
                );
            }
        }
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_action('wp_head', [static::class, 'injectPreloadLinks'], 1);
    }
}
