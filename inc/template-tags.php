<?php
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function base_posted_on($show_modified = false, $show_label = false, $show_only_update = false)
{
    $class = $show_label ? 'caption' : 'sr-only';
    $time_string = '<time class="published" datetime="%1$s">%2$s</time>';
    $modified_string = '<time class="updated" datetime="%1$s">%2$s</time>';

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date())
    );

    $modified_string = sprintf(
        $modified_string,
        esc_attr(get_the_modified_date(DATE_W3C)),
        esc_html(get_the_modified_date())
    );

    if (! $show_only_update || get_the_date(DATE_W3C) === get_the_modified_date(DATE_W3C)) {
        return '<span class="posted-on"><span class="' . $class . '">' . __('Published at', 'base') . '</span> ' . $time_string . '</span>';
    }

    if ($show_modified && get_the_date(DATE_W3C) !== get_the_modified_date(DATE_W3C)) {
        return '<span class="updated-on"><span class="' . $class . '">' . __('Last updated at', 'base') . '</span> ' . $modified_string . '</span>';
    }
}

/**
 * Prints HTML with meta information for the categories.
 */
function base_post_categories($type = 'link')
{
    $categories = get_the_category();

    if (! empty($categories)) {
        echo '<span class="sr-only">' . __('Categories:', 'base') . '</span>';

        foreach ($categories as $category) {
            if ($type === 'link') {
                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
            } else {
                echo '<span>' . esc_html($category->name) . '</span>';
            }
        }
    }
}

/**
 * Print categories.
 */
function base_list_all_post_categories() {
    $categories = get_categories([
        'hide_empty' => true,
    ]);

    $classes_home = is_home() ? 'category-label--active' : '';
    $current_category = get_queried_object();
    $classes_active = '';

    if (!empty($categories)) {
        echo '<div class="post-categories">';
        echo '<div class="container">';
        echo '<div class="post-categories__inner">';

        echo '<a href="' . esc_url(get_post_type_archive_link('post')) . '" class="category-label ' . $classes_home . '">' . __('All', 'base') . '</a> ';

        foreach ($categories as $category) {
            $category_link = get_category_link($category->term_id);

            if (isset($current_category) && $current_category->term_id === $category->term_id) {
                $classes_active = 'category-label--active';
            } else {
                $classes_active = '';
            }

            echo '<a href="' . esc_url($category_link) . '" class="category-label ' . esc_attr($classes_active) . '">' . esc_html($category->name) . '</a> ';
        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

/**
 * Prepare an SVG for inline display.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/SVG/Tutorial/SVG_In_HTML_Introduction
 *
 * @param string|false $path
 * @param array<string, string> $attrs
 */
function base_get_inline_svg($path, array $attrs = [], int $ttl = 3600): string
{
    $empty_svg = '<svg class="svg-empty"></svg>';

    $cache_key = 'file-'.md5($path.serialize($attrs));
    $xml = wp_cache_get($cache_key, 'svg-contents');
    if ($xml !== false) {
        return $xml;
    }

    if ($path === false || !file_exists($path)) {
        return $empty_svg;
    }

    $contents = file_get_contents($path);
    if ($contents === false || $contents === '') {
        return $empty_svg;
    }

    $document = new \DOMDocument();
    $document->loadXML($contents);

    $svg_elems = $document->getElementsByTagName('svg');
    if ($svg_elems->length === 0) {
        return $empty_svg;
    }
    $svg_elems->item(0)->removeAttribute('id');

    foreach ($attrs as $attr_name => $attr_value) {
        $svg_elems->item(0)->setAttribute($attr_name, $attr_value);
    }

    $svg_elems->item(0)->setAttribute('role', 'img');

    $xml = $document->saveXML($svg_elems->item(0));

    wp_cache_set($cache_key, $xml, 'svg-contents', $ttl);

    return $xml;
}

/**
 * Prepare an SVG from assets directory for inline display.
 *
 * @param array<string, string> $attrs
 */
function base_get_inline_svg_asset(string $filename, array $attrs = [], int $ttl = 3600): string
{
    return base_get_inline_svg(get_template_directory().'/assets/img/'.$filename, $attrs, $ttl);
}

/**
 * Prepare an SVG from Media for inline display.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/SVG/Tutorial/SVG_In_HTML_Introduction
 *
 * @param array<string, string> $attrs
 */
function base_get_inline_svg_media(int $attachment_id, array $attrs = [], int $ttl = 3600): string
{
    return base_get_inline_svg(get_attached_file($attachment_id), $attrs, $ttl);
}

/**
 * Prepare an SVG as an icon.
 */
function base_get_inline_svg_icon(string $filename, string $class_string = 'icon'): string
{
    return base_get_inline_svg_asset(
        'icon/' . $filename,
        [
            'class' => $class_string,
            'width' => '24',
            'height' => '24',
        ]
    );
}
