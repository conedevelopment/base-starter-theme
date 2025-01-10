<?php get_header(); ?>

    <main id="content" class="l-front-page">
        <?php
        get_template_part('template-parts/block/hero', '', [
            'title' => 'A WordPress starter theme for classical themes built with ACF',
            'subtitle' => 'WordPress the Cone way',
            'description' => 'This a minimalistic and modular WordPress starter theme with Spruce CSS and Alpine.js. We use this structure to create all of our custom themes for WP.',
            'buttons' => [
                [
                    'type' => 'default',
                    'button' => [
                        'url' => 'https://example.com',
                        'title' => 'Learn More',
                    ],
                ],
                [
                    'type' => 'outline',
                    'button' => [
                        'url' => 'https://example.com/contact',
                        'title' => 'Contact Us',
                    ],
                ],
            ],
        ]);
        ?>
    </main>

<?php
get_footer();
