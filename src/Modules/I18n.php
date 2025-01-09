<?php

namespace Base\Modules;

class I18n extends Module
{
    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_action('admin_bar_menu', function ($menu) {
            foreach ($menu->get_nodes() as $key => $node) {
                if (preg_match('/^blog-\d+$/', $key) > 0) {
                    preg_match('/\/(hu|de|en)\//', $node->href, $lang);

                    $node->title .= sprintf(' (%s)', strtoupper($lang[1] ?? 'en'));
                    $menu->remove_node($key);
                    $menu->add_node((array) $node);
                }
            }
        }, 999);
    }
}