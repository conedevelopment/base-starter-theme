<?php
/**
 * Template Name: Builder
 * Template Post Type: page
 */

get_header();

while (have_posts()) :
    the_post();
    ?>
    <main id="content" class="site-main">
        <?php get_template_part('template-parts/builder'); ?>
    </main>

    <?php
endwhile;

get_footer();
