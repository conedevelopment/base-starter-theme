<?php
global $wp_query;

get_header();
?>
    <main id="content" class="site-main">
        <?php
        get_template_part('template-parts/block/hero', '', [
            'title' => __('Blog', 'base'),
            'alignment' => 'center',
            'background' => 'dotted',
            'size' => 'small',
            'breadcrumb' => 'show',
        ]);
        base_list_all_post_categories();
        ?>
        <div class="l-post-list">
            <div class="container">
                <?php
                if (have_posts()) :
                    $base_counter = 1;

                    while (have_posts()) :
                        the_post();
                        if ($base_counter === 1) {
                            echo '<div class="l-post-list__inner">';
                        };

                        if ($base_counter === 4) {
                            echo '</div>';
                            get_template_part('template-parts/block/newsletter');
                            echo '<div class="l-post-list__inner l-post-list__inner--small">';
                        };

                        get_template_part('template-parts/card/post', '', [
                            'type' => $base_counter > 3 ? 'small' : 'regular',
                        ]);

                        if ($base_counter === $wp_query->post_count) {
                            echo '</div>';
                        };

                        $base_counter++;
                    endwhile;
                endif;
                ?>
                <?php if (get_the_posts_pagination()) : ?>
                    <div class="l-post-list__more">
                        <?php
                        the_posts_pagination([
                            'mid_size'  => 2,
                            'prev_text' => __('Previous', 'base'),
                            'next_text' => __('Next', 'base'),
                        ]);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        get_template_part('template-parts/block/cta', '', [
            'title' => get_field('base_blog_cta_title', 'option'),
            'description' => get_field('base_blog_cta_description', 'option'),
            'buttons' => get_field('base_blog_cta_buttons', 'option'),
        ]);
        ?>
    </main>

<?php
get_footer();
