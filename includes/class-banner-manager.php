<?php

class Banner_Manager {
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'banner-manager';
        $this->version = BANNER_MANAGER_VERSION;
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once BANNER_MANAGER_PLUGIN_DIR . 'includes/class-banner-manager-loader.php';
        require_once BANNER_MANAGER_PLUGIN_DIR . 'includes/class-banner-manager-i18n.php';
        require_once BANNER_MANAGER_PLUGIN_DIR . 'admin/class-banner-manager-admin.php';
        require_once BANNER_MANAGER_PLUGIN_DIR . 'public/class-banner-manager-public.php';

        $this->loader = new Banner_Manager_Loader();
    }

    private function set_locale() {
        $plugin_i18n = new Banner_Manager_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks() {
        $plugin_admin = new Banner_Manager_Admin($this->get_plugin_name(), $this->get_version());
        
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'register_settings');
    }

    private function define_public_hooks() {
        $plugin_public = new Banner_Manager_Public($this->get_plugin_name(), $this->get_version());
        
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('init', $plugin_public, 'register_shortcodes');
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
} 