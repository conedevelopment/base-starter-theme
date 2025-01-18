<?php
global $wp_query;

get_header();
?>
    <main id="content" class="l-blog">
        <?php
        get_template_part('template-parts/block/hero', '', [
            'class' => 'hero--small',
            'title' => __('Blog', 'base'),
        ]);
        base_list_all_post_categories();
        ?>

        <?php if (have_posts()) : ?>
            <div class="l-post-list">
                <div class="container">
                    <div class="l-post-list__inner">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/card/post');
                        endwhile;
                        ?>
                    </div>
                </div>
                <div class="container">
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
        <?php endif; ?>
    </main>

<?php
get_footer();
