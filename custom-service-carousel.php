<?php
/*
Plugin Name: Custom Service Carousel
Plugin URI: https://saqf.sa
Description: A beautiful, responsive service carousel with secondary services and search functionality
Version: 2.0.9
Author: saqf.sa
Author URI: https://saqf.sa
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: custom-service-carousel
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
$plugin_version = '1.0.0';
if (preg_match('/Version:\s*(.+)/i', file_get_contents(__FILE__), $matches)) {
    $plugin_version = trim($matches[1]);
}
define('CSC_VERSION', $plugin_version);
define('CSC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CSC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once MY_PLUGIN_PATH . 'functions.php';


// Enqueue scripts and styles
function csc_enqueue_scripts() {
    // Enqueue CSS
    wp_enqueue_style(
        'csc-style',
        CSC_PLUGIN_URL . 'assets/css/style.css',
        array(),
        CSC_VERSION
    );
    
    // Enqueue Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
        array(),
        '5.15.4'
    );
    
    // Enqueue JavaScript
    wp_enqueue_script(
        'csc-script',
        CSC_PLUGIN_URL . 'assets/js/script.js',
        array('jquery'),
        CSC_VERSION,
        true
    );
    
    // Localize script with data
    $secondary_services = csc_get_secondary_services();
    $tertiary_services = csc_get_tertiary_services();
    $filter_field_mapping = csc_get_filter_field_mapping();
    wp_localize_script('csc-script', 'cscData', array(
        'secondaryServices' => $secondary_services,
        'tertiaryServices' => $tertiary_services,
        'filterFieldMapping' => $filter_field_mapping
    ));
    
    // Localize script for AJAX
    wp_localize_script('csc-script', 'cscAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('csc_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'csc_enqueue_scripts');
