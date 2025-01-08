<?php

namespace Base\Modules;

final class Auth extends Module
{
    /**
     * Register the auth related assets.
     *
     * @return void
     */
    public function assets(): void
    {
        wp_enqueue_style('base-login', get_template_directory_uri() . '/assets/css/login.css');
    }

    /**
     * Remove the shake effect from the login form.
     *
     * @return void
     */
    public function removeShakeJs(): void
    {
        remove_action('login_footer', 'wp_shake_js', 12);
    }

    /**
     * Get the logo text for the login screen.
     *
     * @return string
     */
    public function getLogoText(): string
    {
        return get_option('blogname');
    }

    /**
     * Get the logo link URL for the login screen.
     *
     * @return string
     */
    public function getLogoUrl(): string
    {
        return home_url();
    }

    /**
     * Boot the module.
     *
     * @return void
     */
    public function boot(): void
    {
        $module = new static();

        add_filter('login_headerurl', [$module, 'getLogoUrl']);
        add_filter('login_headertext', [$module, 'getLogoText']);
        add_action('login_enqueue_scripts', [$module, 'assets']);
        add_action('login_footer', [$module, 'removeShakeJs']);
    }
}
