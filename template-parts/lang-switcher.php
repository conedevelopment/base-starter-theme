<?php

$base_default_language = 'en';

/**
 * Template part for displaying language switcher for a multisite.
 */
$base_language_list = [
    'hu' => __('Hungarian', 'base'),
    'en' => __('English', 'base'),
];

if (is_multisite()) :
    $base_sites = get_sites([
        'fields' => 'WPLANG',
    ]);

    ?>
    <div
        @click.outside="open = false"
        x-data="{ open: false }"
        class="lang-switcher"
        x-cloak
        @keyup.escape.window="open = false"
    >
        <button
            @click="open = ! open"
            :aria-expanded="open"
            type="button"
            class="lang-switcher__control"
        >
            <?php echo substr(get_locale(), 0, 2); ?>
            <?php echo base_get_inline_svg_icon('chevron-up.svg', 'btn__icon'); ?>
        </button>
        <ul
            x-trap="open"
            x-show="open"
            x-transition.origin.top.left
            class="lang-switcher__panel"
        >
            <?php
            foreach ($base_sites as $site) {
                $output = '';
                $base_language = '';

                if ($site->path === '/') {
                    $base_language = $base_default_language;
                } else {
                    $base_language = substr($site->path, 1, 2);
                }

                if (get_current_blog_id() != $site->blog_id) {
                    $output .= '<li>';
                    $output .= '<a hreflang="' . $base_language .'" href="' . $site->path . '" aria-label="' . $base_language_list[$base_language] . '">';
                    $output .= $base_language;
                    $output .= '</a>';
                    $output .= '</li>';

                    echo $output;
                }
            }
            ?>
        </ul>
    </div>
<?php
endif;
