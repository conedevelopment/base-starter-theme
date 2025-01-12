<footer class="site-footer">
    <div class="container">
        <div class="site-footer__top">
            <div class="site-footer__column">
                <a class="site-footer__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
                    <?php echo base_get_inline_svg_asset('base-logo.svg'); ?>
                </a>
            </div>
            <?php
            for ($i = 1; $i <= 3; $i++) :
                $base_footer_menu = 'footer-' . $i;
                if (has_nav_menu($base_footer_menu)) : ?>
                    <div class="site-footer__column">
                        <h3 class="site-footer__title">
                            <?php echo wp_get_nav_menu_name($base_footer_menu); ?>
                        </h3>
                        <?php
                        wp_nav_menu([
                            'theme_location' => $base_footer_menu,
                            'container' => '',
                            'items_wrap' => '<ul class="site-footer__navigation">%3$s</ul>',
                        ]);
                        ?>
                    </div>
                <?php endif;
            endfor;
            ?>
        </div>
        <div class="site-footer__bottom">
            <?php get_template_part('template-parts/theme-switcher'); ?>
            <p class="site-footer__copyright">
                <?php
                echo date('Y');
                echo ' ';
                the_field('base_footer_copyright', 'option');
                ?>
            </p>
            <?php get_template_part('template-parts/socials'); ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
