<?php
/*
Plugin Name: Custom Service Carousel
Plugin URI: https://saqf.sa
Description: A beautiful, responsive service carousel with secondary services and search functionality
Version: 1.0
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
define('CSC_VERSION', '1.0.0');
define('CSC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CSC_PLUGIN_URL', plugin_dir_url(__FILE__));

// Admin settings removed - using default values

// Get main services data - 4 main categories only
function csc_get_main_services() {
    return array(
        array(
            'title' => 'البناء الذاتي والتشطيب',
            'icon' => 'fas fa-tools',
            'category' => 'البناء الذاتي والتشطيب',
            'url' => 'bina-wa-tashtib'
        ),
        array(
            'title' => 'صيانة المنازل الدورية',
            'icon' => 'fas fa-home',
            'category' => 'صيانة المنازل الدورية',
            'url' => 'siyana-manazil'
        ),
        array(
            'title' => 'الموردين والمواد',
            'icon' => 'fas fa-cube',
            'category' => 'الموردين والمواد',
            'url' => 'mawridin-wa-mawad'
        ),
        array(
            'title' => 'المعدات والخدمات المساندة',
            'icon' => 'fas fa-truck',
            'category' => 'المعدات والخدمات المساندة',
            'url' => 'muadat-wa-khidmat'
        )
    );
}

// Get secondary services data - updated based on new structure
function csc_get_secondary_services() {
    