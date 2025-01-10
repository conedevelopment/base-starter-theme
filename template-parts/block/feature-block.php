<div class="l-feature-block">
    <div class="container">
        <div class="l-feature-block__inner">
            <?php
            get_template_part('template-parts/block-partial/heading', '', [
                'class' => 'heading--center',
            ]);

            if (have_rows('feature_block_items')) : ?>
                <div class="l-feature-block__list">
                    <?php
                    while (have_rows('feature_block_items')) {
                        the_row();
                        get_template_part('template-parts/card/feature-block');
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
