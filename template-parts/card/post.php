<?php
$base_type = $args['type'] ?? 'regular';
?>

<div class="post-card post-card--<?php echo esc_attr($base_type); ?>">
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('medium', ['class'=>'post-card__thumbnail']); ?>
    <?php endif; ?>
    <div class="post-card__body">
        <div class="post-card__meta">
            <?php if (get_the_category()) : ?>
                <div class="post-card__tags">
                    <?php base_post_categories(); ?>
                </div>
            <?php endif; ?>
            <?php base_posted_on(); ?>
        </div>
        <h2 class="post-card__title">
            <a class="post-card__link" href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>
        <?php if ($base_type !== 'small') : ?>
            <p class="post-card__description">
                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
            </p>
        <?php endif; ?>
    </div>
</div>
