<?php get_header(); ?>

    <main id="content" class="site-main">
        <div class="l-not-found">
            <div class="container">
                <div class="l-not-found__inner">
                    <div class="l-not-found__content">
                        <h1 class="l-not-found__title"><?php esc_html_e('Error 404, we couldn\'t find the page', 'base'); ?></h1>
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'error-404',
                            'container' => '',
                            'items_wrap' => '<ul class="l-not-found__navigation">%3$s</ul>',
                        ]);
                        ?>
                        <div class="l-not-found__btn">
                            <a href="<?php echo esc_url(home_url()); ?>" class="btn btn--primary btn--lg">
                                <?php esc_html_e('Back to home', 'base'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
get_footer();
