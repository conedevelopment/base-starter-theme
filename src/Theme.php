<?php

namespace Base;

use Base\Modules\Acf;
use Base\Modules\Assets;
use Base\Modules\Auth;
use Base\Modules\Comments;
use Base\Modules\Config;
use Base\Modules\Mailchimp;
use Base\Modules\Performance;
use Base\Modules\Photoswipe;
use Base\Modules\Preload;
use Base\Modules\Search;
use Base\Modules\Shortcodes;
use Base\Modules\Tinymce;
use Base\Modules\Wpcf7;
use Base\Support\Str;

use WP_Error;
use WP_Query;

final class Theme
{
    /**
     * Setup the theme.
     */
    public static function setup(): void
    {
        load_textdomain('base', get_template_directory()  . '/languages/' . determine_locale() . '.mo');

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('editor-styles');
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]);

        add_editor_style('assets/css/editor-style.css');

        register_nav_menus([
            'header' => esc_html__('Header', 'base'),
            'footer-1' => esc_html__('Footer (1)', 'base'),
            'footer-2' => esc_html__('Footer (2)', 'base'),
            'footer-3' => esc_html__('Footer (3)', 'base'),
            'error-404' => esc_html__('404', 'base'),
        ]);
    }

    /**
     * Set the content width.
     */
    public static function setContentWidth(): void
    {
        $GLOBALS['content_width'] = apply_filters('sf_content_width', 1120);
    }

    /**
     * Add type="module" to script tags with handle containing "module".
     */
    public static function moduleTypeAttribute(string $tag, string $handle, string $src): string
    {
        if (! str_contains($handle, 'module')) {
            return $tag;
        }

        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }

    /**
     * Limit the posts in the query.
     */
    public static function limitPosts(WP_Query $query): void
    {
        if ($query->is_main_query() && is_author() || is_category()) {
            $query->set('posts_per_page', 10);
        }
    }

    /**
     * Add IDs to <h2> and <h3>.
     */
    public static function wrapHeadings($content)
    {
        if (get_post_type() === 'post' && is_single()) {
            $pattern = '/<h([2-3])>(.*?)<\/h\1>/';

            $content = preg_replace_callback($pattern, function($matches) {
                $heading_level = $matches[1];
                $heading_text = $matches[2];
                $slug = Str::slugify($heading_text);
                $copy_btn = '
                    <button
                        @click="
                            navigator.clipboard.writeText(window.location.href + \'#' . $slug . '\');
                            copied = true;
                            setTimeout(() => copied = false, 2000);
                        "
                        class="copy-link-button"
                        aria-label="' . __('Copy link', 'base') . '"
                    >
                        #
                        <span x-show="copied" class="copy-link-button__label">
                            ' . __('Link copied', 'base') . '
                        </span>
                    </button>
                ';

                $heading = '<h'.$heading_level.' id="' . $slug . '" x-data="{ copied: false }">' . $copy_btn . $heading_text . '</h' . $heading_level . '>';

                return $heading;
            }, $content);
        }

        return $content;
    }

    /**
     * Boot the theme.
     */
    public static function boot(): void
    {
        (new Config)->boot();
        (new Acf)->boot();
        (new Assets)->boot();
        (new Auth)->boot();
        (new Comments)->boot();
        (new Mailchimp)->boot();
        (new Performance)->boot();
        (new Photoswipe)->boot();
        (new Preload)->boot();
        (new Search)->boot();
        (new Shortcodes)->boot();
        (new Tinymce)->boot();
        (new Wpcf7)->boot();

        add_action('after_setup_theme', [static::class, 'setup']);
        add_action('after_setup_theme', [static::class, 'setContentWidth'], 0);
        add_filter('script_loader_tag', [static::class, 'moduleTypeAttribute'], 10, 3);
        add_action('pre_get_posts', [static::class, 'limitPosts']);
        add_filter('the_content', [static::class, 'wrapHeadings']);
    }
}
