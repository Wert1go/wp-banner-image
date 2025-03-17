<?php

class Banner_Manager_i18n {
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'banner-manager',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
} 