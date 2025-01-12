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
        get_template_part('template-parts/block-static/feature-grid', '', [
            'heading' => [
                'title' => 'Working Faster and More Consistent',
                'subtitle' => 'Features of Base',
                'description' => 'This a minimalistic and modular WordPress starter theme with Spruce CSS and Alpine.js. We use this structure to create all of our custom themes for WP.',
                'class' => 'heading--center',
            ],
            'items' => [
                [
                    'icon' => get_template_directory_uri().'/assets/img/feature-grid/1.png',
                    'title' => 'Customizable Design',
                    'description' => 'Easily modify styles and layouts using intuitive customization options.',
                ],
                [
                    'icon' => get_template_directory_uri().'/assets/img/feature-grid/2.png',
                    'title' => 'Optimized Performance',
                    'description' => 'Built with lightweight code for fast loading times and smooth user experience.',
                ],
                [
                    'icon' => get_template_directory_uri().'/assets/img/feature-grid/3.png',
                    'title' => 'Secure Foundation',
                    'description' => 'Follow the latest security standards to ensure a safe site for your users.',
                ],
                [
                    'icon' => get_template_directory_uri().'/assets/img/feature-grid/4.png',
                    'title' => 'Developer Friendly',
                    'description' => 'Includes clean, well-commented code to streamline development and customization.',
                ],
                [
                    'icon' => get_template_directory_uri().'/assets/img/feature-grid/5.png',
                    'title' => 'Responsive Design',
                    'description' => 'A fully responsive layout that looks great on any device, from mobile to desktop.',
                ],
                [
                    'icon' => get_template_directory_uri().'/assets/img/feature-grid/6.png',
                    'title' => 'Future Ready',
                    'description' => 'Easily extendable to adapt to new WordPress features and requirements.',
                ],
            ],
        ]);
        ?>
    </main>

<?php
get_footer();
