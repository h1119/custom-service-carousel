<?php 
// This file contains additional plugin functions and filters for the Custom Service Carousel plugin.

// Add a new page template for the service carousel demo
add_filter('theme_page_templates', function ($templates) {
    $templates['service-carousel-template.php'] = __('Service Carousel demo', 'saqf');
    return $templates;
});

// Include the plugin template for the service carousel demo
add_filter('template_include', function ($template) {
    if (is_singular() && get_page_template_slug() === 'service-carousel-template.php') {
        $plugin_template = MY_PLUGIN_PATH . 'templates/service-carousel-template.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
});

// Shortcode to display the carousel
// This is the main function that displays the carousel on the page
function csc_service_carousel_shortcode($atts) {
    // Parse shortcode attributes
    $atts = shortcode_atts(array(
        'link' => 'directory-listing' // Default to 'directory-listing' if not provided
    ), $atts, 'service_carousel');
    // Pass the link to the template
    $directory_base_slug = $atts['link'];
    
    ob_start();
    // Make the link available to the template
    $GLOBALS['csc_current_link'] = $directory_base_slug;
    include CSC_PLUGIN_DIR . 'templates/carousel.php';
    unset($GLOBALS['csc_current_link']);
    return ob_get_clean();
}
add_shortcode('service_carousel', 'csc_service_carousel_shortcode');

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
            'title' => 'الصيانة والتنظيف',
            'icon' => 'fas fa-home',
            'category' => 'الصيانة والتنظيف',
            'url' => 'siyana-manazil'
        ),
        array(
            'title' => 'الموردين والمواد',
            'icon' => 'fas fa-cube',
            'category' => 'الموردين والمواد',
            'url' => 'mawridin-wa-mawad'
        ),
        array(
            'title' => 'التأجير والخدمات المساندة',
            'icon' => 'fas fa-truck',
            'category' => 'التأجير والخدمات المساندة',
            'url' => 'muadat-wa-khidmat'
        )
    );
}

// Get secondary services data - updated based on new structure
function csc_get_secondary_services() {
    return array(
        'البناء الذاتي والتشطيب' => array(
            array('id' => 'secondary-service-83', 'icon' => 'fas fa-hard-hat', 'title' => 'المقاولات'),
            array('id' => 'secondary-service-31', 'icon' => 'fas fa-tools', 'title' => 'أعمال المعادن والخشب'),
            array('id' => 'secondary-service-40', 'icon' => 'fas fa-warehouse', 'title' => 'كراجات'),
            array('id' => 'secondary-service-38', 'icon' => 'fas fa-water', 'title' => 'خزانات'),
            array('id' => 'secondary-service-32', 'icon' => 'fas fa-brush', 'title' => 'أعمال الديكور'),
            array('id' => 'secondary-service-26', 'icon' => 'fas fa-briefcase', 'title' => 'مكاتب'),
            array('id' => 'secondary-service-30', 'icon' => 'fas fa-snowflake', 'title' => 'تكييف'),
            array('id' => 'secondary-service-34', 'icon' => 'fas fa-swimmer', 'title' => 'الأعمال المائية والحدائق'),
            array('id' => 'secondary-service-33', 'icon' => 'fas fa-elevator', 'title' => 'مصاعد'),
            array('id' => 'secondary-service-127', 'icon' => 'fas fa-utensils', 'title' => 'المطابخ'),
            array('id' => 'secondary-service-35', 'icon' => 'fas fa-shield-alt', 'title' => 'خدمات الأمان والسلامة')
        ),
        'الصيانة والتنظيف' => array(
            array('id' => 'secondary-service-143', 'icon' => 'fas fa-tint', 'title' => 'سباكة'),
            array('id' => 'secondary-service-144', 'icon' => 'fas fa-bolt', 'title' => 'كهرباء'),
            array('id' => 'secondary-service-163', 'icon' => 'fas fa-snowflake', 'title' => 'صيانة مكايفات'),
            array('id' => 'secondary-service-164', 'icon' => 'fas fa-wind', 'title' => 'تنظيف مكايفات'),
            array('id' => 'secondary-service-165', 'icon' => 'fas fa-hammer', 'title' => 'نجارة'),
            array('id' => 'secondary-service-166', 'icon' => 'fas fa-couch', 'title' => 'تركيب اثاث'),
            array('id' => 'secondary-service-132', 'icon' => 'fas fa-soap', 'title' => 'تنظيف اثاث'),
            array('id' => 'secondary-service-39', 'icon' => 'fas fa-broom', 'title' => 'نظافة عامة'),
            array('id' => 'secondary-service-167', 'icon' => 'fas fa-brush', 'title' => 'جلي رخام'),
            array('id' => 'secondary-service-168', 'icon' => 'fas fa-blender', 'title' => 'أجهزة منزليه'),
            array('id' => 'secondary-service-133', 'icon' => 'fas fa-bug', 'title' => 'مكافحة حشرات'),
            array('id' => 'secondary-service-171', 'icon' => 'fas fa-tint-slash', 'title' => 'تسريبات'),
            array('id' => 'secondary-service-169', 'icon' => 'fas fa-ban', 'title' => 'انسدادات'),
            array('id' => 'secondary-service-170', 'icon' => 'fas fa-solar-panel', 'title' => 'طاقة شمسية'),
        ),
        'الموردين والمواد' => array(
            array('id' => 'secondary-service-143', 'icon' => 'fas fa-tint', 'title' => 'سباكة'),
            array('id' => 'secondary-service-144', 'icon' => 'fas fa-bolt', 'title' => 'كهرباء'),
            array('id' => 'secondary-service-145', 'icon' => 'fas fa-water', 'title' => 'ماء'),
            array('id' => 'secondary-service-146', 'icon' => 'fas fa-lightbulb', 'title' => 'انارة'),
            array('id' => 'secondary-service-147', 'icon' => 'fas fa-plug', 'title' => 'كيابل'),
            array('id' => 'secondary-service-148', 'icon' => 'fas fa-shower', 'title' => 'مواد صحية'),
            array('id' => 'secondary-service-149', 'icon' => 'fas fa-toilet', 'title' => 'الصرف الصحي'),
            array('id' => 'secondary-service-150', 'icon' => 'fas fa-mountain', 'title' => 'رمل'),
            array('id' => 'secondary-service-151', 'icon' => 'fas fa-dumbbell', 'title' => 'حديد'),
            array('id' => 'secondary-service-152', 'icon' => 'fas fa-th-large', 'title' => 'طابوق'),
            array('id' => 'secondary-service-153', 'icon' => 'fas fa-cubes', 'title' => 'خرسانة'),
            array('id' => 'secondary-service-154', 'icon' => 'fas fa-gem', 'title' => 'حجر'),
            array('id' => 'secondary-service-155', 'icon' => 'fas fa-fire-extinguisher', 'title' => 'عزل مائي وحراري'),
            array('id' => 'secondary-service-156', 'icon' => 'fas fa-truck-loading', 'title' => 'بيس كورس'),
            array('id' => 'secondary-service-157', 'icon' => 'fas fa-tree', 'title' => 'خشب'),
            array('id' => 'secondary-service-158', 'icon' => 'fas fa-window-maximize', 'title' => 'ألمنيوم'),
            array('id' => 'secondary-service-159', 'icon' => 'fas fa-border-style', 'title' => 'رخام'),
            array('id' => 'secondary-service-160', 'icon' => 'fas fa-th', 'title' => 'بلاط'),
        ),
        'التأجير والخدمات المساندة' => array(
            array('id' => 'secondary-service-29', 'icon' => 'fas fa-database', 'title' => 'تأجير خزانات'),
            array('id' => 'secondary-service-134', 'icon' => 'fas fa-truck-pickup', 'title' => 'معدات خفيفة'),
            array('id' => 'secondary-service-135', 'icon' => 'fas fa-truck-moving', 'title' => 'معدات ثقيلة'),
            array('id' => 'secondary-service-136', 'icon' => 'fas fa-tractor', 'title' => 'بوكلين'),
            array('id' => 'secondary-service-137', 'icon' => 'fas fa-truck', 'title' => 'شيول'),
            array('id' => 'secondary-service-138', 'icon' => 'fas fa-dolly', 'title' => 'رافعه شوكية'),
            array('id' => 'secondary-service-139', 'icon' => 'fas fa-crane', 'title' => 'كرين'),
            array('id' => 'secondary-service-140', 'icon' => 'fas fa-weight-hanging', 'title' => 'رصاصه'),
            array('id' => 'secondary-service-36', 'icon' => 'fas fa-ladder', 'title' => 'سقالات'),
            array('id' => 'secondary-service-128', 'icon' => 'fas fa-recycle', 'title' => 'سكراب'),
            array('id' => 'secondary-service-37', 'icon' => 'fas fa-box', 'title' => 'حاويات'),
            array('id' => 'secondary-service-142', 'icon' => 'fas fa-truck', 'title' => 'نقل أثاث'),
        )
    );
}

// Get tertiary services data - third-level options for specific secondary services
function csc_get_tertiary_services() {
    return array(
        'البناء الذاتي والتشطيب' => array(
            'المقاولات' => array(
                array('icon' => 'fas fa-tools', 'title' => 'تشطيب مواد'),
                array('icon' => 'fas fa-tools', 'title' => 'تشطيب بدون مواد'),
                array('icon' => 'fas fa-tools', 'title' => 'تشطيب أعمال مقطوعة'),
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
                array('icon' => 'fas fa-building', 'title' => 'التعدين'),
                array('icon' => 'fas fa-paint-roller', 'title' => 'القطاع الصخري'),
                array('icon' => 'fas fa-th-large', 'title' => 'الطاقة الشمسية'),
            ),
            'أعمال المعادن والخشب' => array(
                array('icon' => 'fas fa-building', 'title' => 'ألمنيوم'),
                array('icon' => 'fas fa-toolbox', 'title' => 'نجارة'),
                array('icon' => 'fas fa-tools', 'title' => 'حدادة'),
                array('icon' => 'fas fa-door-open', 'title' => 'أبواب'),
                array('icon' => 'fas fa-couch', 'title' => 'درابزين'),
                array('icon' => 'fas fa-umbrella', 'title' => 'مظلات'),
                array('icon' => 'fas fa-shield-alt', 'title' => 'سواتر'),
                array('icon' => 'fas fa-window-maximize', 'title' => 'نوافذ'),
            ),
            'الخزانات' => array(
                array('icon' => 'fas fa-tint', 'title' => 'مياه'),
                array('icon' => 'fas fa-burn', 'title' => 'غاز'),
                array('icon' => 'fas fa-water', 'title' => 'بيارات'),
                array('icon' => 'fas fa-drum', 'title' => 'خزانات دفن'),
            ),
            'الديكور الداخلي' => array(
                array('icon' => 'fas fa-archway', 'title' => 'جبس بورد'),
                array('icon' => 'fas fa-gopuram', 'title' => 'حجر صناعي'),
                array('icon' => 'fas fa-th-large', 'title' => 'GRC / جي آر سي'),
                array('icon' => 'fas fa-brush', 'title' => 'دهانات'),
            ),
            'مكاتب هندسية' => array(
                array('icon' => 'fas fa-couch', 'title' => 'تصميم داخلي'),
                array('icon' => 'fas fa-home', 'title' => 'تصميم خارجي'),
                array('icon' => 'fas fa-leaf', 'title' => 'تصميم حدائق'),
                array('icon' => 'fas fa-drafting-compass', 'title' => 'استشارات هندسية'),
                array('icon' => 'fas fa-map', 'title' => 'مخططات'),
                array('icon' => 'fas fa-cogs', 'title' => 'إدارة مشاريع'),
            ),
            'الأعمال المائية والحدائق' => array(
                array('icon' => 'fas fa-swimming-pool', 'title' => 'مسابح'),
                array('icon' => 'fas fa-water', 'title' => 'نوافير'),
                array('icon' => 'fas fa-tint', 'title' => 'شلالات'),
                array('icon' => 'fas fa-tree', 'title' => 'تنسيق حدائق'),
            ),
            'خدمات الأمان والسلامة' => array(
                array('icon' => 'fas fa-shield-alt', 'title' => 'أنظمة إنذار'),
                array('icon' => 'fas fa-broadcast-tower', 'title' => 'أنظمة مراقبة'),
                array('icon' => 'fas fa-fire-extinguisher', 'title' => 'طفايات حريق'),
                array('icon' => 'fas fa-home', 'title' => 'أنظمة المنازل الذكية'),
            ),
        ),
        'صيانة المنازل الدورية' => array(
            'سباكة' => array( //143
                array('icon' => 'fas fa-faucet', 'title' => 'تسليك مجاري'),
                array('icon' => 'fas fa-toilet', 'title' => 'صيانة دورات مياه'),
                array('icon' => 'fas fa-shower', 'title' => 'صيانة دش'),
                array('icon' => 'fas fa-wrench', 'title' => 'إصلاح تسريبات'),
            ),
        ),
    );
}


// AJAX handler for locations (optional - can be extended)
function csc_get_locations_ajax() {
    check_ajax_referer('csc_nonce', 'nonce');
    
    // Return default locations or fetch from database
    // EDIT THIS ARRAY TO CHANGE THE LOCATION LIST
    $locations = array(
        array('region' => 'المنطقة الشرقية', 'name' => 'الدمام'),
        array('region' => 'المنطقة الشرقية', 'name' => 'الخبر'),
        array('region' => 'المنطقة الشرقية', 'name' => 'الظهران'),
        array('region' => 'المنطقة الشرقية', 'name' => 'القطيف'),
        array('region' => 'المنطقة الشرقية', 'name' => 'الأحساء'),
        array('region' => 'المنطقة الشرقية', 'name' => 'حفر الباطن'),
        array('region' => 'المنطقة الشرقية', 'name' => 'الجبيل'),
        array('region' => 'المنطقة الشرقية', 'name' => 'رأس تنورة'),
        array('region' => 'المنطقة الشرقية', 'name' => 'بقيق'),
        array('region' => 'المنطقة الشرقية', 'name' => 'النعيرية'),
        array('region' => 'منطقة الرياض', 'name' => 'الرياض'),
        array('region' => 'منطقة الرياض', 'name' => 'الخرج'),
        array('region' => 'منطقة الرياض', 'name' => 'الدوادمي'),
        array('region' => 'منطقة الرياض', 'name' => 'المجمعة'),
        array('region' => 'منطقة الرياض', 'name' => 'القويعية'),
        array('region' => 'منطقة الرياض', 'name' => 'الأفلاج'),
        array('region' => 'منطقة الرياض', 'name' => 'وادي الدواسر'),
        array('region' => 'منطقة الرياض', 'name' => 'الزلفي'),
        array('region' => 'منطقة الرياض', 'name' => 'شقراء'),
        array('region' => 'منطقة الرياض', 'name' => 'حوطة بني تميم'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'مكة المكرمة'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'جدة'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'الطائف'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'رابغ'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'خليص'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'القنفذة'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'الليث'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'أضم'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'تربة'),
        array('region' => 'منطقة مكة المكرمة', 'name' => 'رنية'),
        array('region' => 'منطقة المدينة المنورة', 'name' => 'المدينة المنورة'),
        array('region' => 'منطقة المدينة المنورة', 'name' => 'ينبع'),
        array('region' => 'منطقة المدينة المنورة', 'name' => 'العلا'),
        array('region' => 'منطقة المدينة المنورة', 'name' => 'المدينة'),
        array('region' => 'منطقة المدينة المنورة', 'name' => 'بدر'),
        array('region' => 'منطقة المدينة المنورة', 'name' => 'خيبر'),
        array('region' => 'منطقة المدينة المنورة', 'name' => 'العيص'),
        array('region' => 'منطقة المدينة المنورة', 'name' => 'الحناكية'),
        array('region' => 'منطقة القصيم', 'name' => 'بريدة'),
        array('region' => 'منطقة القصيم', 'name' => 'عنيزة'),
        array('region' => 'منطقة القصيم', 'name' => 'الرس'),
        array('region' => 'منطقة القصيم', 'name' => 'المذنب'),
        array('region' => 'منطقة القصيم', 'name' => 'البكيرية'),
        array('region' => 'منطقة القصيم', 'name' => 'البدائع'),
        array('region' => 'منطقة القصيم', 'name' => 'الأسياح'),
        array('region' => 'منطقة القصيم', 'name' => 'النبهانية'),
        array('region' => 'منطقة عسير', 'name' => 'أبها'),
        array('region' => 'منطقة عسير', 'name' => 'خميس مشيط'),
        array('region' => 'منطقة عسير', 'name' => 'نجران'),
        array('region' => 'منطقة عسير', 'name' => 'جازان'),
        array('region' => 'منطقة عسير', 'name' => 'صبيا'),
        array('region' => 'منطقة عسير', 'name' => 'أحد رفيدة'),
        array('region' => 'منطقة عسير', 'name' => 'محايل عسير'),
        array('region' => 'منطقة عسير', 'name' => 'النماص'),
        array('region' => 'منطقة عسير', 'name' => 'بلقرن'),
        array('region' => 'منطقة عسير', 'name' => 'تثليث'),
        array('region' => 'منطقة تبوك', 'name' => 'تبوك'),
        array('region' => 'منطقة تبوك', 'name' => 'الوجه'),
        array('region' => 'منطقة تبوك', 'name' => 'ضباء'),
        array('region' => 'منطقة تبوك', 'name' => 'تيماء'),
        array('region' => 'منطقة تبوك', 'name' => 'أملج'),
        array('region' => 'منطقة تبوك', 'name' => 'حقل'),
        array('region' => 'منطقة حائل', 'name' => 'حائل'),
        array('region' => 'منطقة حائل', 'name' => 'بقعاء'),
        array('region' => 'منطقة حائل', 'name' => 'الغزالة'),
        array('region' => 'منطقة حائل', 'name' => 'الشملي'),
        array('region' => 'منطقة الحدود الشمالية', 'name' => 'عرعر'),
        array('region' => 'منطقة الحدود الشمالية', 'name' => 'طريف'),
        array('region' => 'منطقة الحدود الشمالية', 'name' => 'رفحاء'),
        array('region' => 'منطقة الجوف', 'name' => 'سكاكا'),
        array('region' => 'منطقة الجوف', 'name' => 'القريات'),
        array('region' => 'منطقة الجوف', 'name' => 'دومة الجندل'),
        array('region' => 'منطقة الباحة', 'name' => 'الباحة'),
        array('region' => 'منطقة الباحة', 'name' => 'بلجرشي'),
        array('region' => 'منطقة الباحة', 'name' => 'المندق'),
        array('region' => 'منطقة الباحة', 'name' => 'المخواة'),
        array('region' => 'منطقة جازان', 'name' => 'جازان'),
        array('region' => 'منطقة جازان', 'name' => 'صبيا'),
        array('region' => 'منطقة جازان', 'name' => 'أبو عريش'),
        array('region' => 'منطقة جازان', 'name' => 'صامطة'),
        array('region' => 'منطقة جازان', 'name' => 'بيش'),
        array('region' => 'منطقة نجران', 'name' => 'نجران'),
        array('region' => 'منطقة نجران', 'name' => 'شرورة'),
        array('region' => 'منطقة نجران', 'name' => 'حبونا'),
    );
    
    wp_send_json_success(array('locations' => $locations));
}
add_action('wp_ajax_csc_get_locations', 'csc_get_locations_ajax');
add_action('wp_ajax_nopriv_csc_get_locations', 'csc_get_locations_ajax');

