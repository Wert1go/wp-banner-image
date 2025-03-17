<?php

class Banner_Manager_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            BANNER_MANAGER_PLUGIN_URL . 'admin/css/banner-manager-admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_media();
        wp_enqueue_script(
            $this->plugin_name,
            BANNER_MANAGER_PLUGIN_URL . 'admin/js/banner-manager-admin.js',
            array('jquery'),
            $this->version,
            false
        );
    }

    public function add_plugin_admin_menu() {
        add_submenu_page(
            'upload.php', // Parent slug (Media menu)
            'Banner Manager Settings',
            'Banner Manager',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );
    }

    public function register_settings() {
        register_setting($this->plugin_name, 'banner_manager_image');
        register_setting($this->plugin_name, 'banner_manager_url');
        register_setting($this->plugin_name, 'banner_manager_utm_source');
        register_setting($this->plugin_name, 'banner_manager_utm_medium');
        register_setting($this->plugin_name, 'banner_manager_utm_campaign');
    }

    public function display_plugin_setup_page() {
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'settings';
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <h2 class="nav-tab-wrapper">
                <a href="?page=<?php echo $this->plugin_name; ?>&tab=settings" 
                   class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">
                    <?php _e('Settings', 'banner-manager'); ?>
                </a>
                <a href="?page=<?php echo $this->plugin_name; ?>&tab=pages" 
                   class="nav-tab <?php echo $active_tab == 'pages' ? 'nav-tab-active' : ''; ?>">
                    <?php _e('Pages with Banner', 'banner-manager'); ?>
                </a>
            </h2>

            <?php if ($active_tab == 'settings'): ?>
                <?php include_once('partials/banner-manager-admin-display.php'); ?>
            <?php else: ?>
                <?php $this->display_pages_with_shortcode(); ?>
            <?php endif; ?>
        </div>
        <?php
    }

    private function display_pages_with_shortcode() {
        $pages = $this->get_pages_with_shortcode();
        ?>
        <div class="banner-manager-pages">
            <?php if (!empty($pages)): ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th><?php _e('Page Title', 'banner-manager'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $index => $page): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td>
                                    <a href="<?php echo esc_url(get_permalink($page->ID)); ?>" target="_blank">
                                        <?php echo esc_html($page->post_title); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><?php _e('No pages found with the banner shortcode.', 'banner-manager'); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    private function get_pages_with_shortcode() {
        global $wpdb;
        
        $shortcode = '[banner_manager]';
        $pages = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT ID, post_title 
                FROM {$wpdb->posts} 
                WHERE post_content LIKE %s 
                AND post_status = 'publish' 
                AND post_type IN ('post', 'page')",
                '%' . $wpdb->esc_like($shortcode) . '%'
            )
        );
        
        return $pages;
    }
} 