<?php

namespace Base\Modules;

class Comments extends Module
{
    /**
     * Disable support for comments and trackbacks in post types.
     */
    public function disableCommentsPostTypesSupport(): void
    {
        $post_types = get_post_types();

        foreach ($post_types as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    }

    /**
     * Remove comments page in menu.
     */
    public function disableCommentsAdminMenu(): void
    {
        remove_menu_page('edit-comments.php');
    }

    /**
     * Redirect any user trying to access comments page.
     */
    public function disableCommentsAdminMenuRedirect(): void
    {
        global $pagenow;

        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url());
            exit();
        }
    }

    /**
     * Remove comments metabox from dashboard.
     */
    public function disableCommentsDashboard(): void
    {
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    }

    /**
     * Boot the module.
     */
    public function boot(): void
    {
        add_action('init', [$this, 'disableCommentsPostTypesSupport']);
        add_filter('comments_open', '__return_false', 20);
        add_filter('pings_open', '__return_false', 20);
        add_filter('comments_array', '__return_empty_array', 10, 0);
        add_action('admin_menu', [$this, 'disableCommentsAdminMenu']);
        add_action('admin_init', [$this, 'disableCommentsAdminMenuRedirect']);
        add_action('admin_init', [$this, 'disableCommentsDashboard']);
    }
}
