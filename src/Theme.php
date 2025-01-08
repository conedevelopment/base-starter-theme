<?php

namespace Base;

use Base\Modules\Acf;
use Base\Modules\Auth;
use Base\Modules\Comments;
use Base\Modules\Shortcodes;
use Base\Modules\Tinymce;
use Base\Modules\Wpcf7;
use Base\Modules\Mailchimp;
use Base\Modules\Translations;
use Base\Support\Str;
use WP_Error;
use WP_Query;

final class Theme
{
    /**
     * The theme version.
     */
    public const VERSION = '1.0.0';

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
            'error-404' => esc_html__('404', 'base'),
        ]);

        if (!current_user_can('edit_posts')) {
            add_filter('show_admin_bar', '__return_false');
        }

        add_action('admin_bar_menu', function ($menu) {
            foreach ($menu->get_nodes() as $key => $node) {
                if (preg_match('/^blog-\d+$/', $key) > 0) {
                    preg_match('/\/(hu|de|en)\//', $node->href, $lang);

                    $node->title .= sprintf(' (%s)', strtoupper($lang[1] ?? 'en'));
                    $menu->remove_node($key);
                    $menu->add_node((array) $node);
                }
            }
        }, 999);
    }

    /**
     * Set the content width.
     */
    public static function setContentWidth(): void
    {
        $GLOBALS['content_width'] = apply_filters('sf_content_width', 1120);
    }

    /**
     * Asset helper.
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

        wp_enqueue_style('base-main', static::asset('/css/main.css'), [], static::VERSION);

        wp_enqueue_script('base-cookie-handler', static::asset('/js/plugin/cookie-handler.js'), [], static::VERSION);

        // Splide
        wp_enqueue_script('base-splide', static::asset('/js/plugin/splide.min.js'), [], static::VERSION, ['strategy' => 'defer']);
        wp_enqueue_script('base-splide-init', static::asset('/js/splide-init.js'), ['base-splide'], static::VERSION, ['strategy' => 'defer']);

        // Photoswipe
        wp_enqueue_script('base-photoswipe-module', static::asset('/js/plugin/photoswipe.min.js'), [], static::VERSION, true);
        wp_enqueue_script('base-photoswipe-lightbox-module', static::asset('/js/plugin/photoswipe-lightbox.min.js'), ['base-photoswipe-module'], static::VERSION, true);
        wp_enqueue_script('base-photoswipe-init-module', static::asset('/js/photoswipe-init.js'), ['base-photoswipe-module'], static::VERSION, true);

        // Alpine.js
        wp_enqueue_script('base-alipne-focus', static::asset('/js/plugin/alpine-focus.min.js'), [], static::VERSION, ['strategy' => 'defer']);
        wp_enqueue_script('base-alipne', static::asset('/js/plugin/alpine.min.js'), ['base-alipne-focus'], static::VERSION, ['strategy' => 'defer']);

        wp_enqueue_script('base-navigation', static::asset('/js/navigation.js'), [], static::VERSION, ['strategy' => 'defer']);
        wp_enqueue_script('base-header', static::asset('/js/header.js'), [], static::VERSION, ['strategy' => 'defer']);
        wp_enqueue_script('base-scroll-to-top', static::asset('/js/scroll-to-top.js'), [], static::VERSION, ['strategy' => 'defer']);

        // Prism
        wp_enqueue_script('base-prism', static::asset('/js/plugin/prism-custom.min.js'), [], static::VERSION, true);

        // TOC
        if (is_single()) {
            wp_enqueue_script('base-toc', static::asset('/js/toc.js'), [], static::VERSION, true);
        }

        // Plans
        wp_enqueue_script('base-accordion', static::asset('/js/accordion.js'), [], static::VERSION, true);

        wp_enqueue_script('base-theme-switcher', static::asset('/js/theme-switcher.js'), [], static::VERSION, ['strategy' => 'defer']);

        if (wp_get_environment_type() === 'production') {
            wp_enqueue_script('base-cookie-check', static::asset('/js/cookie-check.js'), ['base-cookie-handler'], static::VERSION, true);
            wp_enqueue_script('base-cookie-consent', static::asset('/js/cookie-consent.js'), ['base-cookie-handler'], static::VERSION, true);
            wp_enqueue_script('base-cookie-consent-scripts', static::asset('/js/scripts.js'), ['base-cookie-consent'], static::VERSION, true);
        }

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
     * Clean admin bar.
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
     * Remove Gutenberg Block Library CSS from loading on the frontend
     */
    public static function removeBlockAssets(): void
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS
    }

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
     * Remove tags from posts.
     */
    public static function removeTags(): void
    {
        register_taxonomy('post_tag', []);
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

    /*
     * Add data-pswp-width and data-pswp-height attributes to images in posts.
     */
    public static function addPswpAttributes($content): string
    {
        $output = do_shortcode($content);
        $output = preg_replace('/<a href=\'(.*?)\'/i', '<a href="$1"', $output);

        if (preg_match_all('/<a href="([^"]+\.(?:jpg|jpeg|png|gif|webp))"[^>]*>(.*?)<\/a>/i', $output, $matches)) {
            foreach ($matches[1] as $index => $image_url) {
                $attachment_id = attachment_url_to_postid($image_url);
                $image_dimensions = wp_get_attachment_image_src($attachment_id, 'full');

                if ($image_dimensions) {
                    $height = $image_dimensions[2];
                    $width = $image_dimensions[1];
                } else {
                    $width = $height = null;
                }

                $data_attributes = 'data-pswp-width="' . $width . '" data-pswp-height="' . $height . '" data-cropped="true"';
                $output = str_replace($matches[0][$index], '<a href="' . esc_url($image_url) . '" ' . $data_attributes . '>' . $matches[2][$index] . '</a>', $output);
            }
        }

        return $output;
    }

    /**
     * Remove wpautop from ACF the_content.
     */
    public static function acfWysiwygRemoveWpautop(): void
    {
        remove_filter('the_content', 'wpautop');
        remove_filter('acf_the_content', 'wpautop');

        add_filter('acf_the_content', 'wpautop', 8);
        add_filter('the_content', 'wpautop', 8);
    }

    /**
     * Remove empty paragraphs from the content.
     */
    public static function removeEmptyP($content): string
    {
        $content = preg_replace([
            '#<p>\s*<(div|aside|section|article|header|footer)#',
            '#</(div|aside|section|article|header|footer)>\s*</p>#',
            '#</(div|aside|section|article|header|footer)>\s*<br ?/?>#',
            '#<(div|aside|section|article|header|footer)(.*?)>\s*</p>#',
            '#<p>\s*</(div|aside|section|article|header|footer)#',
        ], [
            '<$1',
            '</$1>',
            '</$1>',
            '<$1$2>',
            '</$1',
        ], $content);

        return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content);
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
     * Simple WP_Query based AJAX search callback.
     */
    public static function ajaxSearch()
    {
        if ( isset( $_GET['s'] ) ) {
            $search_query = sanitize_text_field( $_GET['s'] );

            $args = [
                'post_type' => 'knowledge-base',
                'posts_per_page' => -1,
                's' => $search_query
            ];

            $query = new WP_Query($args);

            $results = [];

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $results[] = [
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'url' => get_permalink(),
                    ];
                }
            }
            wp_reset_postdata();

            wp_send_json($results);
        }

        wp_send_json([]);
    }

    /**
     * Boot the theme.
     */
    public static function boot(): void
    {
        (new Acf)->boot();
        (new Auth)->boot();
        (new Comments)->boot();
        (new Shortcodes)->boot();
        (new Tinymce)->boot();
        (new Wpcf7)->boot();
        (new Mailchimp)->boot();
        (new Translations)->boot();

        add_action('wp_enqueue_scripts', [static::class, 'assets']);
        add_action('after_setup_theme', [static::class, 'setup']);
        add_action('after_setup_theme', [static::class, 'setContentWidth'], 0);
        add_action('wp_before_admin_bar_render', [static::class, 'adminBarCustomization'], 100);
        add_action('wp_enqueue_scripts', [static::class, 'removeBlockAssets'], 100);
        remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
        remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
        add_filter('wp_kses_allowed_html', [static::class, 'wpksesTags'], 10, 1);
        add_filter('the_content', [static::class, 'shortcodeParagraphFix']);
        add_filter('acf_the_content', [static::class, 'shortcodeParagraphFix'], 11);
        add_action('init', [static::class, 'removeTags']);
        add_filter('script_loader_tag', [static::class, 'moduleTypeAttribute'], 10, 3);
        add_filter('the_content', [static::class, 'addPswpAttributes'], 10, 1);
        add_filter('acf_the_content', [static::class, 'addPswpAttributes'], 10, 1);
        add_action('acf/init', [static::class, 'acfWysiwygRemoveWpautop'], 12);
        add_filter('the_content', [static::class, 'removeEmptyP'], 20, 1);
        add_filter('acf_the_content', [static::class, 'removeEmptyP'], 20, 1);
        remove_filter('term_description', 'wpautop');
        add_action('pre_get_posts', [static::class, 'limitPosts']);
        add_filter('the_content', [static::class, 'wrapHeadings']);
        add_action('wp_ajax_nopriv_ajax_search', [static::class, 'ajaxSearch']);
        add_action('wp_ajax_ajax_search', [static::class, 'ajaxSearch']);
    }
}
