<?php

namespace Base\Modules;

class Photoswipe extends Module
{
    /*
     * Add data-pswp-width and data-pswp-height attributes to images in posts.
     */
    public static function addAttributes($content): string
    {
        $output = do_shortcode($content);
        $output = preg_replace('/<a href=\'(.*?)\'/i', '<a href="$1"', $output);

        if (preg_match_all('/<a href="([^"]+\.(?:jpg|jpeg|png|gif|webp))"[^>]*>(.*?)<\/a>/i', $output, $matches)) {
            foreach ($matches[1] as $index => $image_url) {
                $attachment_id = attachment_url_to_postid($image_url);
                $image_dimensions = wp_get_attachment_image_src($attachment_id, 'full');

                if ($image_dimensions) {
                    $height = $image_dimensions[2];
                    $width = $image_dimensions[1];
                } else {
                    $width = $height = null;
                }

                $data_attributes = 'data-pswp-width="' . $width . '" data-pswp-height="' . $height . '" data-cropped="true"';
                $output = str_replace($matches[0][$index], '<a href="' . esc_url($image_url) . '" ' . $data_attributes . '>' . $matches[2][$index] . '</a>', $output);
            }
        }

        return $output;
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_filter('the_content', [static::class, 'addAttributes'], 10, 1);
        add_filter('acf_the_content', [static::class, 'addAttributes'], 10, 1);
    }
}