<?php
$base_template_part_map = [
    'hero' => 'template-parts/block/hero',
    'text' => 'template-parts/block/text',
    'cta' => 'template-parts/block/cta',
    'accordion' => 'template-parts/block/accordion',
    'blog' => 'template-parts/block/post',
    'feature_grid' => 'template-parts/block/feature-grid',
    'feature' => 'template-parts/block/feature',
    'feature_block' => 'template-parts/block/feature-block',
    'logo_wall' => 'template-parts/block/logo-wall',
    'plans_highlight' => 'template-parts/block/plans-highlight',
    'plans_detail' => 'template-parts/block/plans-detail',
    'domains' => 'template-parts/block/domains',
];

if (have_rows('base_block')) :
    while (have_rows('base_block')) {
        the_row();
        if (!array_key_exists(get_row_layout(), $base_template_part_map)) {
            continue;
        }
        get_template_part($base_template_part_map[get_row_layout()]);
    }
else :
    ?>
    <div class="empty-builder-alert">
        <div class="container">
            <div class="empty-builder-alert__inner">
                <?php
                printf(
                    __('<h1 class="h3">You haven\'t built this page yet.</h1><a href="%s" class="btn btn--primary">Edit</a>', 'base'),
                    esc_url(is_user_logged_in() ? get_edit_post_link() : wp_login_url())
                );
                ?>
            </div>
        </div>
    </div>
    <?php
endif;
