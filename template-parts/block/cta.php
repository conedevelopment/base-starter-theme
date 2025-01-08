<?php
$base_title = $args['title'] ?? get_sub_field('title');
$base_description = $args['description'] ?? get_sub_field('description');
$base_buttons = $args['buttons'] ?? get_sub_field('buttons');

if ($base_title) : ?>
    <div class="container">
        <div class="call-to-action">
            <h2 class="call-to-action__title">
                <?php echo $base_title; ?>
            </h2>
            <div class="call-to-action__caption">
                <?php if ($base_description) : ?>
                    <div class="call-to-action__description">
                        <?php echo $base_description; ?>
                    </div>
                <?php endif; ?>
                <?php if ($base_buttons) : ?>
                    <div class="call-to-action__btns">
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
