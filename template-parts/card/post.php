<div class="post-card">
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
            <?php echo base_posted_on(); ?>
        </div>
        <h2 class="post-card__title">
            <a class="post-card__link" href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>
        <p class="post-card__description">
            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
        </p>
    </div>
</div>
