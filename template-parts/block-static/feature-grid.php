<?php
$base_heading = $args['heading'] ?? null;
$base_items = $args['items'] ?? null;
?>
<div class="l-feature-grid">
    <div class="container">
        <div class="l-feature-grid__inner">
            <?php
            if (isset($base_heading) && is_array($base_heading)) {
                get_template_part('template-parts/block-partial/heading', '', [
                    'title' => $base_heading['title'],
                    'subtitle' => $base_heading['subtitle'],
                    'description' => $base_heading['description'],
                    'class' => $base_heading['class'],
                ]);
            }

            if (isset($base_items) && is_array($base_items)) : ?>
                <div class="l-feature-grid__list">
                    <?php
                    foreach ($base_items as $item) {
                        the_row();
                        get_template_part('template-parts/card/feature-grid', '', [
                            'icon' => $item['icon'],
                            'title' => $item['title'],
                            'description' => $item['description'],
                        ]);
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
