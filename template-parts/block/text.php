<div class="l-text l-text--<?php the_sub_field('type'); ?>">
    <div class="container">
        <div class="l-text__inner">
            <div class="post-content l-text__column">
                <?php the_sub_field('first_column'); ?>
            </div>
            <?php if(get_sub_field('type') === 'column') : ?>
                <div class="post-content l-text__column">
                    <?php the_sub_field('second_column'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
