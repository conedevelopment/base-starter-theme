<?php get_header(); ?>
    <main id="content" class="site-main">
        <article class="l-post">
            <?php
            get_template_part('template-parts/block/hero', '', [
                'title' => get_the_title(),
                'description' => base_posted_on(true, true, true),
            ]);
            ?>
            <div class="container container--narrow">
                <div class="l-post__inner">
                    <div class="l-post__content">
                        <div class="post-content">
                            <?php
                            while (have_posts()) :
                                the_post();
                                the_content();
                            endwhile;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>
<?php
get_footer();
