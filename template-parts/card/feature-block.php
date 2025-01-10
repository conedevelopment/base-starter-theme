<div class="feature-block-card">
    <?php if (get_sub_field('thumbnail')) : ?>
        <?php echo wp_get_attachment_image(get_sub_field('thumbnail'), 'thumbnail', false, ['class' => 'feature-block-card__thumbail']); ?>
    <?php endif; ?>
    <div class="feature-block-card__caption">
        <?php if (get_sub_field('title')) : ?>
            <h3 class="feature-block-card__title"><?php the_sub_field('title'); ?></h3>
        <?php endif; ?>
        <?php if (get_sub_field('description')) : ?>
            <p class="feature-block-card__description"><?php the_sub_field('description'); ?></p>
        <?php endif; ?>
    </div>
</div>
