<?php get_header(); ?>

    <main id="content" class="site-main">
        <?php
        get_template_part('template-parts/block/hero', '', [
            'title' => 'A WordPress starter theme for classical themes built with ACF.'
        ]);
        ?>
    </main>

<?php
get_footer();
