<?php
$base_post_type = $args['post_type'] ?? null;
$base_title = $args['title'] ?? null;
$base_card = $args['card'] ?? 'post';
$base_link_url = $args['link_url'] ?? null;
$base_link_caption = $args['link_caption'] ?? null;

$base_args = [
    'post_type' => $base_post_type,
    'posts_per_page' => 4,
    'post__not_in' => [get_the_ID()],
    'ignore_sticky_posts' => true,
    'orderby' => 'rand',
];

$base_query = new WP_Query($base_args);

if ($base_query->have_posts()) : ?>
    <div class="l-post l-post--related">
        <div class="container">
            <div class="l-post__inner">
                <div class="heading heading--space-between">
                    <h2 class="heading__title">
                        <?php echo $base_title; ?>
                    </h2>
                    <a href="<?php echo esc_url($base_link_url); ?>" class="heading__link"><?php echo $base_link_caption; ?></a>
                </div>
                <div class="l-post__list">
                    <?php
                    while ($base_query->have_posts()) {
                        $base_query->the_post();
                        get_template_part('template-parts/card/' . $base_card . '', '', [
                            'type' => 'small',
                        ]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
wp_reset_query();
endif;
