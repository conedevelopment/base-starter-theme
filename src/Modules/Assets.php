<?php

namespace Base\Modules;

use Base\Modules\Config;

class Assets extends Module
{
    /**
     * Helper to only look for the files in the assets folder.
     */
    public static function asset(string $path = ''): string
    {
        return rtrim(get_template_directory_uri() . '/assets/' . ltrim($path, '/'), '/');
    }

    /**
     * Enqueue scripts and styles.
     */
    public static function assets(): void
    {
        // Deregister default styles and scripts
        wp_dequeue_style('classic-theme-styles');

        wp_enqueue_style('base-main', static::asset('/css/main.css'), [], Config::VERSION);

        wp_enqueue_script('base-cookie-handler', static::asset('/js/plugin/cookie-handler.js'), [], Config::VERSION);

        // Splide
        wp_enqueue_script('base-splide', static::asset('/js/plugin/splide.min.js'), [], Config::VERSION, ['strategy' => 'defer']);
        wp_enqueue_script('base-splide-init', static::asset('/js/splide-init.js'), ['base-splide'], Config::VERSION, ['strategy' => 'defer']);

        // Photoswipe
        wp_enqueue_script('base-photoswipe-module', static::asset('/js/plugin/photoswipe.min.js'), [], Config::VERSION, true);
        wp_enqueue_script('base-photoswipe-lightbox-module', static::asset('/js/plugin/photoswipe-lightbox.min.js'), ['base-photoswipe-module'], Config::VERSION, true);
        wp_enqueue_script('base-photoswipe-init-module', static::asset('/js/photoswipe-init.js'), ['base-photoswipe-module'], Config::VERSION, true);

        // Alpine.js
        wp_enqueue_script('base-alipne-focus', static::asset('/js/plugin/alpine-focus.min.js'), [], Config::VERSION, ['strategy' => 'defer']);
        wp_enqueue_script('base-alipne', static::asset('/js/plugin/alpine.min.js'), ['base-alipne-focus'], Config::VERSION, ['strategy' => 'defer']);

        wp_enqueue_script('base-navigation', static::asset('/js/navigation.js'), [], Config::VERSION, ['strategy' => 'defer']);
        wp_enqueue_script('base-header', static::asset('/js/header.js'), [], Config::VERSION, ['strategy' => 'defer']);

        // TOC
        if (is_single()) {
            wp_enqueue_script('base-toc', static::asset('/js/toc.js'), [], Config::VERSION, true);
        }

        wp_enqueue_script('base-accordion', static::asset('/js/accordion.js'), [], Config::VERSION, true);
        wp_enqueue_script('base-theme-switcher', static::asset('/js/theme-switcher.js'), [], Config::VERSION, ['strategy' => 'defer']);

        // if (wp_get_environment_type() === 'production') {
            wp_enqueue_script('base-cookie-check', static::asset('/js/cookie-consent/check.js'), ['base-cookie-handler'], Config::VERSION, true);
            wp_enqueue_script('base-cookie-consent', static::asset('/js/cookie-consent/consent.js'), ['base-cookie-handler'], Config::VERSION, true);
            wp_enqueue_script('base-cookie-consent-scripts', static::asset('/js/cookie-consent/scripts.js'), ['base-cookie-consent'], Config::VERSION, true);
        // }

        wp_localize_script('base-navigation', 'base', [
            'themeUrl' => get_template_directory_uri(),
            'cookie-consent-accept-caption' => __('Allow all', 'base'),
            'cookie-consent-customize-caption' => __('Customize', 'base'),
            'cookie-consent-deny-caption' => __('Decline', 'base'),
            'cookie-consent-selected-caption' => __('Allow selected', 'base'),
            'cookie-consent-description' => get_field('base_consent_description', 'option'),
            'cookie-consent-categories' => get_field('base_consent_categories', 'option'),
        ]);
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_action('wp_enqueue_scripts', [static::class, 'assets']);
    }
}
