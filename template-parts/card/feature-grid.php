<?php
$base_icon = $args['icon'] ?? get_sub_field('icon');
$base_title = $args['title'] ?? get_sub_field('title');
$base_description = $args['description'] ?? get_sub_field('description');
?>
<div class="feature-grid-card">
    <?php if ($base_icon) : ?>
        <img class="feature-grid-card__icon" src="<?php echo $base_icon; ?>" alt="">
    <?php endif; ?>
    <?php if ($base_title) : ?>
        <h3 class="feature-grid-card__title"><?php echo $base_title; ?></h3>
    <?php endif; ?>
    <?php if ($base_description) : ?>
        <p class="feature-grid-card__description"><?php echo $base_description; ?></p>
    <?php endif; ?>
</div>
