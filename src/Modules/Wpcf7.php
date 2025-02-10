<?php

namespace Base\Modules;

final class Wpcf7 extends Module
{
    /**
     * Load scripts only when needed.
     *
     * @return void
     */
    public static function loadScripts(): void
    {
        // Dequeue wpcf7-recaptcha and google-recaptcha
        wp_dequeue_script('wpcf7-recaptcha');
        wp_dequeue_script('google-recaptcha');

        // If current post has cf7 shortcode, enqueue everything back
        global $post;

        if (isset($post->post_content) && has_shortcode($post->post_content, 'contact-form-7')
            || is_page_template('template-contact.php') || is_page_template('template-application.php') || get_post_type() === 'service') {

            if (function_exists( 'wpcf7_enqueue_scripts')) {
                wpcf7_enqueue_scripts();
                wp_enqueue_script('wpcf7-recaptcha');
                wp_enqueue_script('google-recaptcha');
            }
        }
    }

    /**
     * Add extra class to contact form.
     *
     * @return string
     */
    public function formClass($class): string
    {
        return $class . ' generic-form';
    }

    /**
     * Boot the module.
     *
     * @return void
     */
    public function boot(): void
    {
        add_filter('wpcf7_autop_or_not', '__return_false');
        add_filter('wpcf7_load_css', '__return_false');
        add_filter('wpcf7_load_js', '__return_false');
        add_filter('wpcf7_form_class_attr', [static::class, 'formClass']);
        add_action('wp_enqueue_scripts', [static::class, 'loadScripts'], 20, 0);
    }
}
