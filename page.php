<?php get_header(); ?>
    <main id="content" class="site-main">
        <article class="l-post">
            <div class="container">
                <div class="l-post__heading">
                    <h1 class="l-post__title"><?php the_title(); ?></h1>
                    <div class="l-post__meta"><?php base_posted_on(true, true, true); ?></div>
                </div>
            </div>
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
