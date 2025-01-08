<footer class="site-footer">
    <div class="container">
        <div class="site-footer__inner">
            <div class="site-footer__navigations">
                <?php
                for ($i = 1; $i <= 4; $i++) :
                    $base_footer_menu = 'footer-' . $i;
                    if (has_nav_menu($base_footer_menu)) : ?>
                        <div class="site-footer__navigation">
                            <h3 class="site-footer__title">
                                <?php echo wp_get_nav_menu_name($base_footer_menu); ?>
                            </h3>
                            <?php
                            wp_nav_menu([
                                'theme_location' => $base_footer_menu,
                                'container' => '',
                                'items_wrap' => '<ul>%3$s</ul>',
                            ]);
                            ?>
                        </div>
                    <?php endif;
                endfor;
                ?>
            </div>
            <div class="site-footer__bottom">
                <div class="site-footer__copyright-wrapper">
                    <div class="site-footer__logo-wrapper">
                        <?php get_template_part('template-parts/footer/socials'); ?>
                        <a class="site-footer__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
                            <?php echo base_get_inline_svg_asset('base-logo-light.svg'); ?>
                        </a>
                    </div>
                    <p class="site-footer__copyright">
                        <?php
                        echo date('Y');
                        echo ' ';
                        the_field('base_footer_copyright', 'option');
                        ?>
                    </p>
                </div>
                <div class="site-footer__column">
                    <?php
                    get_template_part('template-parts/lang-switcher');
                    get_template_part('template-parts/scroll-to-top');
                    get_template_part('template-parts/theme-switcher');
                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
