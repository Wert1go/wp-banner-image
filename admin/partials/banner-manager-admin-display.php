<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        ?>
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="banner_manager_image"><?php _e('Banner Image', 'banner-manager'); ?></label>
                </th>
                <td>
                    <input type="text" id="banner_manager_image" name="banner_manager_image" 
                           value="<?php echo esc_attr(get_option('banner_manager_image')); ?>" class="regular-text">
                    <button type="button" class="button" id="upload_image_button"><?php _e('Upload Image', 'banner-manager'); ?></button>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="banner_manager_url"><?php _e('Target URL', 'banner-manager'); ?></label>
                </th>
                <td>
                    <input type="url" id="banner_manager_url" name="banner_manager_url" 
                           value="<?php echo esc_url(get_option('banner_manager_url')); ?>" class="regular-text">
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="banner_manager_utm_source"><?php _e('UTM Source', 'banner-manager'); ?></label>
                </th>
                <td>
                    <input type="text" id="banner_manager_utm_source" name="banner_manager_utm_source" 
                           value="<?php echo esc_attr(get_option('banner_manager_utm_source')); ?>" class="regular-text">
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="banner_manager_utm_medium"><?php _e('UTM Medium', 'banner-manager'); ?></label>
                </th>
                <td>
                    <input type="text" id="banner_manager_utm_medium" name="banner_manager_utm_medium" 
                           value="<?php echo esc_attr(get_option('banner_manager_utm_medium')); ?>" class="regular-text">
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="banner_manager_utm_campaign"><?php _e('UTM Campaign', 'banner-manager'); ?></label>
                </th>
                <td>
                    <input type="text" id="banner_manager_utm_campaign" name="banner_manager_utm_campaign" 
                           value="<?php echo esc_attr(get_option('banner_manager_utm_campaign')); ?>" class="regular-text">
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div> 