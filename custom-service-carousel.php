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
    return array(
        'البناء الذاتي والتشطيب' => array(
            array('icon' => 'fas fa-tools', 'title' => 'تشطيب مواد'),
            array('icon' => 'fas fa-tools', 'title' => 'تشطيب بدون مواد'),
            array('icon' => 'fas fa-tools', 'title' => 'تشطيب أعمال مقطوعة'),
            array('icon' => 'fas fa-tools', 'title' => 'تشطيب صيانة'),
            array('icon' => 'fas fa-tools', 'title' => 'عظم مواد'),
            array('icon' => 'fas fa-tools', 'title' => 'عظم بدون مواد'),
            array('icon' => 'fas fa-tools', 'title' => 'عظم أعمال مقطوعة'),
            array('icon' => 'fas fa-tools', 'title' => 'عظم صيانة'),
            array('icon' => 'fas fa-tools', 'title' => 'عوازل'),
            array('icon' => 'fas fa-tools', 'title' => 'إحلال'),
            array('icon' => 'fas fa-tools', 'title' => 'هدم'),
            array('icon' => 'fas fa-tools', 'title' => 'ترميم'),
            array('icon' => 'fas fa-bolt', 'title' => 'كهرباء تأسيس'),
            array('icon' => 'fas fa-bolt', 'title' => 'كهرباء تشطيب'),
            array('icon' => 'fas fa-bolt', 'title' => 'كهرباء أعمال مقطوعة'),
            array('icon' => 'fas fa-road', 'title' => 'أعمال أرصفة'),
            array('icon' => 'fas fa-tint', 'title' => 'سباكة تأسيس'),
            array('icon' => 'fas fa-tint', 'title' => 'سباكة تشطيب'),
            array('icon' => 'fas fa-tint', 'title' => 'سباكة أعمال مقطوعة'),
            array('icon' => 'fas fa-flask', 'title' => 'فحص تربة'),
            array('icon' => 'fas fa-ruler', 'title' => 'صبغ'),
            array('icon' => 'fas fa-th-large', 'title' => 'تبليط'),
            array('icon' => 'fas fa-paint-roller', 'title' => 'لياسة'),
            array('icon' => 'fas fa-building', 'title' => 'التعدين والقطاع الصخري'),
            array('icon' => 'fas fa-building', 'title' => 'الألمنيوم'),
            array('icon' => 'fas fa-toolbox', 'title' => 'نجارة'),
            array('icon' => 'fas fa-tools', 'title' => 'حدادة'),
            array('icon' => 'fas fa-door-open', 'title' => 'أبواب'),
            array('icon' => 'fas fa-couch', 'title' => 'دربزين'),
            array('icon' => 'fas fa-umbrella', 'title' => 'مظلات'),
            array('icon' => 'fas fa-shield-alt', 'title' => 'سواتر'),
            array('icon' => 'fas fa-window-maximize', 'title' => 'نوافذ'),
            array('icon' => 'fas fa-warehouse', 'title' => 'كراجات'),
            array('icon' => 'fas fa-tint', 'title' => 'ماء'),
            array('icon' => 'fas fa-burn', 'title' => 'غاز'),
            array('icon' => 'fas fa-water', 'title' => 'بيارات'),
            array('icon' => 'fas fa-archway', 'title' => 'الجبس'),
            array('icon' => 'fas fa-gopuram', 'title' => 'الحجر'),
            array('icon' => 'fas fa-th-large', 'title' => 'GRC / جي آر سي'),
            array('icon' => 'fas fa-couch', 'title' => 'تصميم داخلي'),
            array('icon' => 'fas fa-home', 'title' => 'تصميم خارجي'),
            array('icon' => 'fas fa-leaf', 'title' => 'تصميم حدائق'),
            array('icon' => 'fas fa-drafting-compass', 'title' => 'استشارات هندسية'),
            array('icon' => 'fas fa-map', 'title' => 'مخططات'),
            array('icon' => 'fas fa-cogs', 'title' => 'خدمات عامة'),
            array('icon' => 'fas fa-broom', 'title' => 'النظافة ومكافحة الحشرات'),
            array('icon' => 'fas fa-snowflake', 'title' => 'تكييف'),
            array('icon' => 'fas fa-warehouse', 'title' => 'كراجات'),
            array('icon' => 'fas fa-swimming-pool', 'title' => 'مسابح / نوافير / شلالات / تنفيذ الحدائق'),
            array('icon' => 'fas fa-arrow-up', 'title' => 'مصاعد'),
            array('icon' => 'fas fa-utensils', 'title' => 'المطابخ'),
            array('icon' => 'fas fa-shield-alt', 'title' => 'خدمات الأمان والسلامة والبيوت الذكية')
        ),
        'صيانة المنازل الدورية' => array(
            array('icon' => 'fas fa-tint', 'title' => 'سباكة'),
            array('icon' => 'fas fa-bolt', 'title' => 'كهرباء'),
            array('icon' => 'fas fa-snowflake', 'title' => 'التكييف'),
            array('icon' => 'fas fa-toolbox', 'title' => 'نجارة وتركيب اثاث'),
            array('icon' => 'fas fa-broom', 'title' => 'نظافة'),
            array('icon' => 'fas fa-blender', 'title' => 'أجهزة منزليه'),
            array('icon' => 'fas fa-bug', 'title' => 'مكافحة حشرات'),
            array('icon' => 'fas fa-tint', 'title' => 'تسريبات')
        ),
        'الموردين والمواد' => array(
            array('icon' => 'fas fa-tint', 'title' => 'سباكة'),
            array('icon' => 'fas fa-bolt', 'title' => 'كهرباء'),
            array('icon' => 'fas fa-tint', 'title' => 'ماء'),
            array('icon' => 'fas fa-water', 'title' => 'الصرف الصحي'),
            array('icon' => 'fas fa-mountain', 'title' => 'رمل'),
            array('icon' => 'fas fa-hammer', 'title' => 'حديد'),
            array('icon' => 'fas fa-th', 'title' => 'طابوق'),
            array('icon' => 'fas fa-cubes', 'title' => 'خرسانة'),
            array('icon' => 'fas fa-gem', 'title' => 'حجر'),
            array('icon' => 'fas fa-fill-drip', 'title' => 'عزل مائي وحراري'),
            array('icon' => 'fas fa-truck-loading', 'title' => 'بيس كورس'),
            array('icon' => 'fas fa-tree', 'title' => 'خشب'),
            array('icon' => 'fas fa-window-maximize', 'title' => 'ألمنيوم')
        ),
        'المعدات والخدمات المساندة' => array(
            array('icon' => 'fas fa-database', 'title' => 'تأجير خزانات'),
            array('icon' => 'fas fa-truck-pickup', 'title' => 'معدات خفيفة'),
            array('icon' => 'fas fa-truck-moving', 'title' => 'معدات ثقيلة'),
            array('icon' => 'fas fa-tractor', 'title' => 'بوكلين'),
            array('icon' => 'fas fa-truck', 'title' => 'شيول'),
            array('icon' => 'fas fa-forklift', 'title' => 'فورك لفت / رافعه شوكية'),
            array('icon' => 'fas fa-crane', 'title' => 'كرين'),
            array('icon' => 'fas fa-compress', 'title' => 'رصاصه'),
            array('icon' => 'fas fa-ladder', 'title' => 'سقالات'),
            array('icon' => 'fas fa-recycle', 'title' => 'سكراب'),
            array('icon' => 'fas fa-box', 'title' => 'حاويات')
        )
    );
}

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
    wp_localize_script('csc-script', 'cscData', array(
        'secondaryServices' => $secondary_services
    ));
    
    // Localize script for AJAX
    wp_localize_script('csc-script', 'cscAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('csc_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'csc_enqueue_scripts');

// Shortcode to display the carousel
function csc_service_carousel_shortcode($atts) {
    ob_start();
    include CSC_PLUGIN_DIR . 'templates/carousel.php';
    return ob_get_clean();
}
add_shortcode('service_carousel', 'csc_service_carousel_shortcode');

// AJAX handler for locations (optional - can be extended)
function csc_get_locations_ajax() {
    check_ajax_referer('csc_nonce', 'nonce');
    
    // Return default locations or fetch from database
    $locations = array(
        array('region' => 'المنطقة الشرقية', 'name' => 'الدمام'),
        array('region' => 'المنطقة الشرقية', 'name' => 'الخبر'),
        array('region' => 'المنطقة الشرقية', 'name' => 'الظهران'),
        array('region' => 'منطقة الرياض', 'name' => 'الرياض'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'مكة المكرمة'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'جدة'),
        array('region' => 'منطقة المدينة المنورة', 'name' => 'المدينة المنورة'),
        array('region' => 'منطقة القصيم', 'name' => 'بريدة'),
        array('region' => 'منطقة عسير', 'name' => 'أبها'),
        array('region' => 'منطقة تبوك', 'name' => 'تبوك'),
        array('region' => 'منطقة حائل', 'name' => 'حائل')
    );
    
    wp_send_json_success(array('locations' => $locations));
}
add_action('wp_ajax_csc_get_locations', 'csc_get_locations_ajax');
add_action('wp_ajax_nopriv_csc_get_locations', 'csc_get_locations_ajax');