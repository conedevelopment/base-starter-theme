<?php

namespace Base\Modules;

class Config extends Module
{
    /**
     * The theme version.
     */
    public const VERSION = '1.0.0';

    /**
     * Enable iframe tags in WYSIWYG editor.
     */
    public static function wpksesTags(array $tags): array
    {
        $tags['iframe'] = [
            'src' => true,
            'height' => true,
            'width' => true,
            'frameborder' => true,
            'allowfullscreen' => true,
            'style' => true,
            'title' => true,
        ];

        return $tags;
    }

    /**
     * Cleanup admin bar.
     */
    public static function adminBarCustomization(): void
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
        $wp_admin_bar->remove_node('search');
        $wp_admin_bar->remove_node('customize');
        $wp_admin_bar->remove_node('comments');
        $wp_admin_bar->remove_menu('wpseo-menu');
        $wp_admin_bar->remove_menu('tribe-events');
    }

    /**
     * Remove tags from posts.
     */
    public static function removeTags(): void
    {
        register_taxonomy('post_tag', []);
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_action('wp_before_admin_bar_render', [static::class, 'adminBarCustomization'], 100);
        add_filter('wp_kses_allowed_html', [static::class, 'wpksesTags'], 10, 1);
        add_action('init', [static::class, 'removeTags']);
    }
}