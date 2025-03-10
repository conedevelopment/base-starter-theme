<?php

namespace Base\Modules;

use WP_Query;

class Search extends Module
{
    /**
     * Simple WP_Query based AJAX search callback.
     */
    public static function ajaxSearch()
    {
        if ( isset( $_GET['s'] ) ) {
            $search_query = sanitize_text_field( $_GET['s'] );

            $args = [
                'post_type' => 'post',
                'posts_per_page' => -1,
                's' => $search_query
            ];

            $query = new WP_Query($args);

            $results = [];

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $results[] = [
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'url' => get_permalink(),
                    ];
                }
            }
            
            wp_reset_postdata();

            wp_send_json($results);
        }

        wp_send_json([]);
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_action('wp_ajax_nopriv_ajax_search', [static::class, 'ajaxSearch']);
        add_action('wp_ajax_ajax_search', [static::class, 'ajaxSearch']);
    }
}
