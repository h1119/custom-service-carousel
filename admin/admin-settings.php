<?php
if (!defined('ABSPATH')) exit;

class ServiceCarouselAdmin {
    private $options;

    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    public function add_plugin_page() {
        add_menu_page(
            'Service Carousel Settings',
            'Service Carousel',
            'manage_options',
            'service-carousel-settings',
            array($this, 'create_admin_page'),
            'dashicons-slides',
            30
        );
    }

    public function create_admin_page() {
        $this->options = get_option('service_carousel_options');
        ?>
        <div class="wrap">
            <h1>Service Carousel Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('service_carousel_option_group');
                do_settings_sections('service-carousel-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function page_init() {
        register_setting(
            'service_carousel_option_group',
            'service_carousel_options',
            array($this, 'sanitize')
        );

        add_settings_section(
            'service_carousel_setting_section',
            'General Settings',
            array($this, 'section_info'),
            'service-carousel-settings'
        );

        // Search Bar Toggle
        add_settings_field(
            'enable_search',
            'Enable Search Bar',
            array($this, 'enable_search_callback'),
            'service-carousel-settings',
            'service_carousel_setting_section'
        );

        // Carousel Width
        add_settings_field(
            'carousel_width',
            'Carousel Width (px)',
            array($this, 'carousel_width_callback'),
            'service-carousel-settings',
            'service_carousel_setting_section'
        );

        // Colors
        add_settings_field(
            'primary_color',
            'Primary Color',
            array($this, 'primary_color_callback'),
            'service-carousel-settings',
            'service_carousel_setting_section'
        );

        add_settings_field(
            'secondary_color',
            'Secondary Color',
            array($this, 'secondary_color_callback'),
            'service-carousel-settings',
            'service_carousel_setting_section'
        );

        // Box Settings
        add_settings_field(
            'box_min_width',
            'Box Minimum Width (px)',
            array($this, 'box_min_width_callback'),
            'service-carousel-settings',
            'service_carousel_setting_section'
        );

        add_settings_field(
            'box_max_width',
            'Box Maximum Width (px)',
            array($this, 'box_max_width_callback'),
            'service-carousel-settings',
            'service_carousel_setting_section'
        );

        // Secondary Services Section
        add_settings_section(
            'secondary_services_section',
            'Secondary Services Display',
            array($this, 'secondary_services_section_info'),
            'service-carousel-settings'
        );

        // Desktop Display
        add_settings_field(
            'desktop_columns',
            'Desktop Columns (1200px+)',
            array($this, 'desktop_columns_callback'),
            'service-carousel-settings',
            'secondary_services_section'
        );

        // Tablet Display
        add_settings_field(
            'tablet_columns',
            'Tablet Columns (768px-1199px)',
            array($this, 'tablet_columns_callback'),
            'service-carousel-settings',
            'secondary_services_section'
        );

        // Mobile Display
        add_settings_field(
            'mobile_columns',
            'Mobile Columns (<768px)',
            array($this, 'mobile_columns_callback'),
            'service-carousel-settings',
            'secondary_services_section'
        );
    }

    public function sanitize($input) {
        $new_input = array();
        $new_input['enable_search'] = isset($input['enable_search']) ? 1 : 0;
        $new_input['carousel_width'] = absint($input['carousel_width']);
        $new_input['primary_color'] = sanitize_hex_color($input['primary_color']);
        $new_input['secondary_color'] = sanitize_hex_color($input['secondary_color']);
        $new_input['box_min_width'] = absint($input['box_min_width']);
        $new_input['box_max_width'] = absint($input['box_max_width']);
        $new_input['desktop_columns'] = absint($input['desktop_columns']);
        $new_input['tablet_columns'] = absint($input['tablet_columns']);
        $new_input['mobile_columns'] = absint($input['mobile_columns']);
        return $new_input;
    }

    public function section_info() {
        echo 'Customize your Service Carousel appearance and functionality:';
    }

    public function secondary_services_section_info() {
        echo 'Configure how secondary services are displayed on different screen sizes:';
    }

    public function enable_search_callback() {
        printf(
            '<input type="checkbox" id="enable_search" name="service_carousel_options[enable_search]" %s />',
            isset($this->options['enable_search']) ? 'checked' : ''
        );
    }

    public function carousel_width_callback() {
        printf(
            '<input type="number" id="carousel_width" name="service_carousel_options[carousel_width]" value="%s" />',
            isset($this->options['carousel_width']) ? esc_attr($this->options['carousel_width']) : '1400'
        );
    }

    public function primary_color_callback() {
        printf(
            '<input type="color" id="primary_color" name="service_carousel_options[primary_color]" value="%s" />',
            isset($this->options['primary_color']) ? esc_attr($this->options['primary_color']) : '#007bff'
        );
    }

    public function secondary_color_callback() {
        printf(
            '<input type="color" id="secondary_color" name="service_carousel_options[secondary_color]" value="%s" />',
            isset($this->options['secondary_color']) ? esc_attr($this->options['secondary_color']) : '#0056b3'
        );
    }

    public function box_min_width_callback() {
        printf(
            '<input type="number" id="box_min_width" name="service_carousel_options[box_min_width]" value="%s" />',
            isset($this->options['box_min_width']) ? esc_attr($this->options['box_min_width']) : '200'
        );
    }

    public function box_max_width_callback() {
        printf(
            '<input type="number" id="box_max_width" name="service_carousel_options[box_max_width]" value="%s" />',
            isset($this->options['box_max_width']) ? esc_attr($this->options['box_max_width']) : '400'
        );
    }

    public function desktop_columns_callback() {
        $value = isset($this->options['desktop_columns']) ? $this->options['desktop_columns'] : 3;
        ?>
        <select id="desktop_columns" name="service_carousel_options[desktop_columns]">
            <option value="1" <?php selected($value, 1); ?>>1 Column</option>
            <option value="2" <?php selected($value, 2); ?>>2 Columns</option>
            <option value="3" <?php selected($value, 3); ?>>3 Columns</option>
            <option value="4" <?php selected($value, 4); ?>>4 Columns</option>
        </select>
        <?php
    }

    public function tablet_columns_callback() {
        $value = isset($this->options['tablet_columns']) ? $this->options['tablet_columns'] : 2;
        ?>
        <select id="tablet_columns" name="service_carousel_options[tablet_columns]">
            <option value="1" <?php selected($value, 1); ?>>1 Column</option>
            <option value="2" <?php selected($value, 2); ?>>2 Columns</option>
            <option value="3" <?php selected($value, 3); ?>>3 Columns</option>
        </select>
        <?php
    }

    public function mobile_columns_callback() {
        $value = isset($this->options['mobile_columns']) ? $this->options['mobile_columns'] : 1;
        ?>
        <select id="mobile_columns" name="service_carousel_options[mobile_columns]">
            <option value="1" <?php selected($value, 1); ?>>1 Column</option>
            <option value="2" <?php selected($value, 2); ?>>2 Columns</option>
        </select>
        <?php
    }

    public function enqueue_admin_scripts($hook) {
        if ('toplevel_page_service-carousel-settings' !== $hook) {
            return;
        }

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script('jquery');

        wp_enqueue_style(
            'service-carousel-admin',
            plugins_url('css/admin-style.css', __FILE__),
            array(),
            '1.0.0'
        );

        wp_enqueue_script(
            'service-carousel-admin',
            plugins_url('js/admin-script.js', __FILE__),
            array('jquery', 'wp-color-picker'),
            '1.0.0',
            true
        );
    }
}

if (is_admin()) {
    $service_carousel_admin = new ServiceCarouselAdmin();
} 