<?php
$base_toc = base_toc(get_the_content());

get_header(); ?>
    <main id="content" class="site-main">
        <article class="l-post l-post--single">
            <?php
            get_template_part('template-parts/block/hero', '', [
                'class' => 'hero--small',
                'title' => get_the_title(),
                'description' => base_posted_on(true, true, true) . base_post_categories(),
                'show_breadcrumb' => true,
            ]);
            ?>
            <div class="container">
                <div class="l-post__inner <?php if ($base_toc) : ?>l-post__inner--toc<?php endif; ?>">
                    <?php if ($base_toc) : ?>
                        <div class="l-post__sidebar">
                            <div class="toc l-post__toc">
                                <div class="heading">
                                    <h2 class="toc__title"><?php _e('Table of Content', 'base'); ?></h2>
                                </div>
                                <?php echo $base_toc; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="l-post__content">
                        <?php if (get_post_type() === 'post' && has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', ['class' => 'l-post__thumbnail']); ?>
                        <?php endif; ?>
                        <div class="post-content">
                            <?php
                            while (have_posts()) :
                                the_post();
                                the_content();
                            endwhile;
                            ?>
                        </div>
                        <?php if (get_post_type() === 'post') : ?>
                            <div class="l-post__author">
                                <?php
                                get_template_part('template-parts/post-author');
                                $base_authors = get_field('base_author');
                                if ($base_authors) {
                                    foreach ($base_authors as $id) {
                                        get_template_part('template-parts/post-author', '', [
                                            'id' => $id,
                                        ]);
                                    }
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </article>
        <?php get_template_part('template-parts/related-post', '', [
            'post_type' => get_post_type(),
            'card' => get_post_type() === 'post' ? 'post' : 'kb',
            'title' => __('More posts', 'base'),
            'link_url' => get_post_type_archive_link(get_post_type()),
            'link_caption' => __('All posts', 'base'),
        ]); ?>
    </main>
<?php
get_footer();
