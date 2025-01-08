<div class="l-accordion">
    <div class="container container--medium">
        <?php
        get_template_part('template-parts/block-partial/heading', '', [
            'class' => 'heading--center',
        ]);

        if (have_rows('accordion')) : ?>
            <div class="l-accordion__inner">
                <div class="accordion-list">
                    <?php while (have_rows('accordion')) : the_row();
                        if (get_sub_field('title')) :
                        ?>
                            <div class="accordion-card">
                                <h3 class="accordion-card__title">
                                    <?php the_sub_field('title'); ?>
                                </h3>
                                <div class="accordion-card__content" aria-hidden="true">
                                    <div>
                                        <?php the_sub_field('description'); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endif;
                    endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
