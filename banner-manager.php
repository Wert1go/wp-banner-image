<?php
/**
 * Plugin Name: Banner Manager
 * Plugin URI: 
 * Description: A simple banner management plugin with UTM tracking support
 * Version: 1.0.0
 * Author: 
 * Text Domain: banner-manager
 * Domain Path: /languages
 * Requires at least: 5.8.1
 * Requires PHP: 7.2
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('BANNER_MANAGER_VERSION', '1.0.0');
define('BANNER_MANAGER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BANNER_MANAGER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once BANNER_MANAGER_PLUGIN_DIR . 'includes/class-banner-manager.php';
require_once BANNER_MANAGER_PLUGIN_DIR . 'includes/class-banner-manager-loader.php';
require_once BANNER_MANAGER_PLUGIN_DIR . 'includes/class-banner-manager-i18n.php';
require_once BANNER_MANAGER_PLUGIN_DIR . 'admin/class-banner-manager-admin.php';
require_once BANNER_MANAGER_PLUGIN_DIR . 'public/class-banner-manager-public.php';

// Initialize the plugin
function run_banner_manager() {
    $plugin = new Banner_Manager();
    $plugin->run();
}
run_banner_manager(); 