<div class="site-footer__socials">
    <?php if (get_field('base_social_youtube', 'option')) : ?>
        <a href="<?php the_field('base_social_youtube', 'option'); ?>" target="_blank" class="site-footer__social site-footer__social--youtube" arial-labe="YouTube">
            <?php echo base_get_inline_svg_icon('social/youtube.svg'); ?>
        </a>
    <?php endif; ?>
    <?php if (get_field('base_social_instagram', 'option')) : ?>
        <a href="<?php the_field('base_social_instagram', 'option'); ?>" target="_blank" class="site-footer__social" arial-labe="Instagram">
            <?php echo base_get_inline_svg_icon('social/instagram.svg'); ?>
        </a>
    <?php endif; ?>
    <?php if (get_field('base_social_tiktok', 'option')) : ?>
        <a href="<?php the_field('base_social_tiktok', 'option'); ?>" target="_blank" class="site-footer__social" arial-labe="TikTok">
            <?php echo base_get_inline_svg_icon('social/tiktok.svg'); ?>
        </a>
    <?php endif; ?>
    <?php if (get_field('base_social_facebook', 'option')) : ?>
        <a href="<?php the_field('base_social_facebook', 'option'); ?>" target="_blank" class="site-footer__social" arial-labe="Facebook">
            <?php echo base_get_inline_svg_icon('social/facebook.svg'); ?>
        </a>
    <?php endif; ?>
</div>
