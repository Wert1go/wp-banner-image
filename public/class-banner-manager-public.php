<?php

class Banner_Manager_Public {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            BANNER_MANAGER_PLUGIN_URL . 'public/css/banner-manager-public.css',
            array(),
            $this->version,
            'all'
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            BANNER_MANAGER_PLUGIN_URL . 'public/js/banner-manager-public.js',
            array('jquery'),
            $this->version,
            false
        );
    }

    public function register_shortcodes() {
        add_shortcode('banner_manager', array($this, 'render_banner'));
    }

    public function render_banner($atts) {
        $banner_image = get_option('banner_manager_image');
        $target_url = get_option('banner_manager_url');
        
        if (empty($banner_image) || empty($target_url)) {
            return '';
        }

        // Get UTM parameters
        $utm_source = get_option('banner_manager_utm_source');
        $utm_medium = get_option('banner_manager_utm_medium');
        $utm_campaign = get_option('banner_manager_utm_campaign');
        
        // Get current post ID for UTM term
        $post_id = get_the_ID();
        $utm_term = $post_id;
        
        // Build URL with UTM parameters
        $utm_params = array();
        if (!empty($utm_source)) {
            $utm_params['utm_source'] = $utm_source;
        }
        if (!empty($utm_medium)) {
            $utm_params['utm_medium'] = $utm_medium;
        }
        if (!empty($utm_campaign)) {
            $utm_params['utm_campaign'] = $utm_campaign;
        }
        $utm_params['utm_term'] = $utm_term;
        
        // Add UTM parameters to target URL
        $final_url = add_query_arg($utm_params, $target_url);
        
        // Build banner HTML
        $output = sprintf(
            '<div class="banner-manager-container"><a href="%s" target="_blank" rel="noopener noreferrer"><img src="%s" alt="%s" class="banner-manager-image"></a></div>',
            esc_url($final_url),
            esc_url($banner_image),
            esc_attr(get_the_title())
        );
        
        return $output;
    }
} 