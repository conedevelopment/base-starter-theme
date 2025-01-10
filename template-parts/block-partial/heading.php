<?php
$base_title = get_sub_field('title') ?? null;
$base_subtitle = get_sub_field('subtitle') ?? null;
$base_description = get_sub_field('description') ?? null;
$base_button = get_sub_field('button') ?? null;
$base_show_button = $args['show_button'] ?? false;
$base_class = $args['class'] ?? null;

if ($base_title) : ?>
    <div class="heading <?php echo esc_attr($base_class); ?>">
        <?php if ($base_subtitle) : ?>
            <p class="label-tag heading__subtitle"><?php echo $base_subtitle; ?></p>
        <?php endif; ?>
        <h2 class="heading__title"><?php echo $base_title; ?></h2>
        <?php if ($base_description) : ?>
            <p class="heading__description"><?php echo $base_description; ?></p>
        <?php endif; ?>
        <?php if ($base_show_button && $base_button) : ?>
            <div class="heading__btn">
                <?php base_link($base_button, 'btn btn--outline-primary btn--lg'); ?>
            </div>
        <?php endif; ?>
    </div>
<?php
endif;
