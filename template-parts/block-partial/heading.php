<?php
$base_title = $args['title'] ?? get_sub_field('title');
$base_subtitle = $args['subtitle'] ?? get_sub_field('subtitle');
$base_description = $args['description'] ?? get_sub_field('description');
$base_class = $args['class'] ?? $args['class'];

if ($base_title) : ?>
    <div class="heading <?php echo esc_attr($base_class); ?>">
        <?php if ($base_subtitle) : ?>
            <p class="label-tag heading__subtitle"><?php echo $base_subtitle; ?></p>
        <?php endif; ?>
        <h2 class="heading__title"><?php echo $base_title; ?></h2>
        <?php if ($base_description) : ?>
            <p class="heading__description"><?php echo $base_description; ?></p>
        <?php endif; ?>
    </div>
<?php
endif;
