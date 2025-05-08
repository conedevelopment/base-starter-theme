<?php

namespace Base\Modules;

use Base\Modules\Config;
use Base\Modules\Assets;

class Admin extends Module
{
    /**
     * Enqueue scripts and styles.
     */
    public static function assets(): void
    {
        wp_enqueue_style('base-admin', Assets::asset('/css/admin.css'), [], Config::VERSION);
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_action('admin_enqueue_scripts', [static::class, 'assets']);
    }
}
