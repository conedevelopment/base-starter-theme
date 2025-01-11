<?php

namespace Base\Modules;

use Base\Support\Str;

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
     * Removes empty paragraph tags from shortcodes in WordPress.
     */
    public static function shortcodeParagraphFix(string $content): string
    {
        return strtr($content, [
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']',
        ]);
    }

    /**
     * Hide any admin menu.
     */
    public static function hideAdmminMenu(): void
    {
        remove_submenu_page('themes.php', 'site-editor.php?path=/patterns');
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_action('wp_before_admin_bar_render', [static::class, 'adminBarCustomization'], 100);
        add_filter('wp_kses_allowed_html', [static::class, 'wpksesTags'], 10, 1);
        add_action('init', [static::class, 'removeTags']);
        add_filter('the_content', [Str::class, 'removeEmptyP'], 20, 1);
        add_filter('acf_the_content', [Str::class, 'removeEmptyP'], 20, 1);
        add_filter('the_content', [static::class, 'shortcodeParagraphFix']);
        add_filter('acf_the_content', [static::class, 'shortcodeParagraphFix'], 11);
        remove_filter('term_description', 'wpautop');
        add_action('admin_menu', [static::class, 'hideAdmminMenu']);
    }
}
