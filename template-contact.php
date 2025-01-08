<?php
/* Template Name: Contact */

get_header(); ?>
    <main id="content" class="site-main">
        <?php
        get_template_part('template-parts/block/hero', '', [
            'title' => __('Contact', 'base'),
            'alignment' => 'center',
            'background' => 'dotted',
            'size' => 'small',
            'breadcrumb' => 'show',
        ]);
        ?>
        <div class="l-contact">
            <div class="container">
                <div class="l-contact__inner">
                    <div class="l-contact__column l-contact__column--info">
                        <h2><?php _e('Keep in touch', 'base'); ?></h2>
                        <?php if (get_field('base_contact_address', 'option')) : ?>
                            <div class="contact-card">
                                <div class="contact-card__heading">
                                    <?php echo base_get_inline_svg_icon('marker.svg', 'contact-card__icon'); ?>
                                    <h3 class="contact-card__title"><?php _e('Address', 'base'); ?></h3>
                                </div>
                                <div class="contact-card__description">
                                    <?php if (get_field('base_contact_company_name', 'option')) : ?>
                                        <p><strong><?php the_field('base_contact_company_name', 'option'); ?></strong></p>
                                    <?php endif; ?>
                                    <p><?php the_field('base_contact_address', 'option'); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="l-contact__grid">
                            <?php if (get_field('base_contact_email', 'option')) : ?>
                                <div class="contact-card">
                                    <div class="contact-card__heading">
                                        <?php echo base_get_inline_svg_icon('email.svg', 'contact-card__icon'); ?>
                                        <h3 class="contact-card__title"><?php _e('Email', 'base'); ?></h3>
                                    </div>
                                    <div class="contact-card__description">
                                        <p><a href="mail:<?php the_field('base_contact_email', 'option'); ?>"><?php the_field('base_contact_email', 'option'); ?></a></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (get_field('base_contact_phone', 'option')) : ?>
                                <div class="contact-card">
                                    <div class="contact-card__heading">
                                        <?php echo base_get_inline_svg_icon('phone.svg', 'contact-card__icon'); ?>
                                        <h3 class="contact-card__title"><?php _e('Phone', 'base'); ?></h3>
                                    </div>
                                    <div class="contact-card__description">
                                        <p>
                                            <a href="tel:<?php echo str_replace(' ', '', get_field('base_contact_phone', 'option')); ?>">
                                                <?php the_field('base_contact_phone', 'option'); ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (get_field('base_contact_form_id', 'option')) : ?>
                        <div class="l-contact__column l-contact__column--form">
                            <?php echo do_shortcode('[contact-form-7 id="' . get_field('base_contact_form_id', 'option') . '"]'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php get_template_part('template-parts/block/cta'); ?>
    </main>
<?php
get_footer();
