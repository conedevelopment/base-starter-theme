<?php
$base_class = $args['class'] ?? get_sub_field('hero_class');
$base_title = $args['title'] ?? get_sub_field('hero_title');
$base_subtitle = $args['subtitle'] ?? get_sub_field('hero_subtitle');
$base_description = $args['description'] ?? get_sub_field('hero_description');
$base_buttons = $args['buttons'] ?? get_sub_field('hero_buttons');
$base_breadcrumb = $args['breadcrumb'] ?? get_sub_field('hero_breadcrumb');

if (! $base_title) {
    $base_title = get_the_title();
}

if ($base_title) :
?>
    <div class="hero <?php echo $base_class; ?>">
        <div class="container">
            <div class="hero__inner">
                <?php if ($base_subtitle) : ?>
                    <p class="hero__subtitle">
                        <?php echo $base_subtitle; ?>
                    </p>
                <?php endif; ?>
                <h1 class="hero__title">
                    <?php echo $base_title; ?>
                </h1>
                <?php if ($base_description) : ?>
                    <p class="hero__description"><?php echo $base_description; ?></p>
                <?php endif; ?>
                <?php if ($base_breadcrumb === true && function_exists('bcn_display')) : ?>
                    <div class="breadcrumb-list" typeof="BreadcrumbList" vocab="https://schema.org/">
                        <?php bcn_display(); ?>
                    </div>
                <?php endif; ?>
                <?php if ($base_buttons) : ?>
                    <div class="hero__btns">
                        <?php
                        foreach ($base_buttons as $item) {
                            $base_class = $item['type'] === 'default' ? 'btn btn--primary btn--lg btn--primary-shadow' : 'btn btn--outline-primary btn--lg';
                            base_link($item['button'], $base_class);
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php
endif;
