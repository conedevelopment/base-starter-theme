<?php
$base_template_part_map = [
    'accordion' => 'template-parts/block/accordion',
    'cta' => 'template-parts/block/cta',
    'text' => 'template-parts/block/text',
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
                    __('<h1 class="empty-builder-alert__title">You haven\'t built this page yet.</h1><a href="%s" class="btn btn--primary">Edit</a>', 'base'),
                    esc_url(is_user_logged_in() ? get_edit_post_link() : wp_login_url())
                );
                ?>
            </div>
        </div>
    </div>
    <?php
endif;
