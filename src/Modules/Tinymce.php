<?php

namespace Base\Modules;

class Tinymce extends Module
{
    /**
     * Plus styles in TinyMCE
     */
    public static function styleButton(array $buttons): array
    {
        array_unshift($buttons, 'styleselect');

        return $buttons;
    }

    /**
     * Insert formats.
     */
    public static function insertFormats($init_array): array
    {
        $style_formats = [
            [
                'title' => __('Lead size', 'base'),
                'block' => 'p',
                'classes' => 'lead',
                'wrapper' => false,
            ],
            [
                'title' => __('Check list', 'base'),
                'selector' => 'ul',
                'classes' => 'check-list',
                'wrapper' => false,
            ],
        ];

        $init_array['style_formats'] = json_encode($style_formats);

        return $init_array;
    }

    /**
     * Add shortcode select to TinyMCE
     */
    public static function addShortcodes(): void
    {
        if (! current_user_can('edit_posts') && ! current_user_can('edit_pages')) {
            return;
        }

        if (get_user_option('rich_editing') === 'true') {
            add_filter('mce_external_plugins', [static::class, 'addShortcodeTinymcePlugin']);
            add_filter('mce_buttons', [static::class, 'registerShortcodeButton']);
        }
    }

    /**
     * Register the buttons shortcode.
     */
    public static function registerShortcodeButton($buttons): array
    {
        array_push($buttons, 'base_shortcodes_button');

        return $buttons;
    }

    /**
     * Add shortcode to tinymce.
     */
    public static function addShortcodeTinymcePlugin($plugin_array): array
    {
        $plugin_array['BaseShortcodes'] = get_template_directory_uri() . '/assets/js/tinymce-shortcode.js';

        return $plugin_array;
    }

    /**
     * Customize the toolbar.
     */
    public static function customizeToolbar(array $toolbar): array
    {
        $toolbar['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3';

        return $toolbar;
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_filter('mce_buttons_2', [static::class, 'styleButton']);
        add_filter('tiny_mce_before_init', [static::class, 'insertFormats']);
        add_action('init', [static::class, 'addShortcodes']);
        add_filter('tiny_mce_before_init', [static::class, 'customizeToolbar']);
    }
}
