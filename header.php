<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php get_template_part('template-parts/theme-detection'); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <a class="btn btn--secondary skip-link" href="#content"><?php _e('Jump to content', 'base'); ?></a>

    <header id="top" class="site-header">
        <div class="container">
            <div class="site-header__inner">
                <a class="site-header__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
                    <?php echo base_get_inline_svg_asset('base-logo.svg'); ?>
                </a>
                <nav
                    class="site-navigation"
                    aria-label="<?php _e('Main', 'base'); ?>"
                >
                    <div class="site-navigation__panel">
                        <?php
                        if (has_nav_menu('header')) {
                            wp_nav_menu([
                                'theme_location' => 'header',
                                'container' => '',
                                'items_wrap' => '<ul class="navigation-menu">%3$s</ul>',
                            ]);
                        }

                        if (have_rows('base_header_buttons', 'option')) : ?>
                            <div class="site-header__btns">
                                <?php while (have_rows('base_header_buttons', 'option')) : the_row(); ?>
                                    <?php
                                    $base_class = get_sub_field('type') === 'primary' ? 'btn btn--primary' : 'btn btn--outline-primary';
                                    base_link(get_sub_field('button'), $base_class);
                                    ?>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>
                <button
                    aria-controls="primary-menu"
                    aria-expanded="false"
                    aria-label="<?php _e('Toggle navigation', 'base'); ?>"
                    class="site-navigation__btn"
                    data-action="navigation-toggle"
                >
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>
