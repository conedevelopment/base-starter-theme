add_action('after_setup_theme', static function () {
        // List all features: var_export(array_keys(get_registered_theme_features()));
        remove_theme_support('core-block-patterns');
        remove_theme_support('widgets-block-editor');
    });

    // Remove default wp_head items
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_custom_css_cb', 101);
    remove_action('wp_head', 'wp_print_auto_sizes_contain_css_fix', 1);

    // Disable emojis
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'wp_resource_hints', 2);

    // Remove global styles (FSE)
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

    // Remove block scripts and styles (Gutenberg)
    remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');

    // Remove stylesheet for classic themes
    remove_action('wp_enqueue_scripts', 'wp_enqueue_classic_theme_styles');
    remove_action('wp_head', 'wp_maybe_inline_styles', 1);
    remove_action('wp_footer', 'wp_maybe_inline_styles', 1);

    // Do not show admin bar
    add_filter('show_admin_bar', '__return_false', 100, 1);

    // Do not add robots meta
    add_filter('wp_robots', '__return_empty_array', 100, 1);