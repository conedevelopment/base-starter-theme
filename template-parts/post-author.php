<?php
use Base\Support\SvgIcons;

$base_author_id = $args['id'] ?? get_the_author_meta('ID');

if (is_single() && $base_author_id) :
?>
    <div class="author-card">
        <?php
        echo get_avatar($base_author_id, 96, '', get_the_author_meta('display_name', $base_author_id), [
            'class' => 'author-card__avatar'
        ]);
        ?>
        <div class="author-card__info">
            <h3 class="author-card__name">
                <?php echo get_the_author_meta('display_name', $base_author_id); ?>
            </h3>
            <?php if (get_the_author_meta('description', $base_author_id)) : ?>
                <p class="author-card__bio">
                    <?php echo get_the_author_meta('description', $base_author_id); ?>
                </p>
            <?php endif; ?>

            <div class="author-card__socials">
                <?php
                $author_socials = get_user_meta($base_author_id, 'autodescription-user-settings', true);

                if (is_array($author_socials)) {
                    if (!empty($author_socials['facebook_page'])) {
                        $facebook_page = esc_url($author_socials['facebook_page']);
                        echo '<a class="author-card__social" href="' . $facebook_page . '" target="_blank" aria-label="Facebook">' . base_get_inline_svg_icon('social/facebook.svg') . '</a>';
                    }

                    if (!empty($author_socials['twitter_page'])) {
                        $twitter_page = esc_html($author_socials['twitter_page']);
                        echo '<a class="author-card__social" href="https://x.com/' . ltrim($twitter_page, '@') . '" target="_blank" aria-label="X">' . base_get_inline_svg_icon('social/x.svg') . '</a>';
                    }
                }
                ?>
                <a href="<?php echo esc_url(get_author_posts_url($base_author_id)); ?>" class="author-archive">
                    <?php printf(esc_html__('View all posts by %s', 'base'), esc_html(get_the_author_meta('display_name', $base_author_id))); ?>
                </a>
            </div>
        </div>
    </div>
<?php
endif;
