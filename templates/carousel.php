<?php
/**
 * Service Categories Template
 * 
 * This template displays 4 main service categories in a grid layout
 */

// Get main services (4 categories only)
$main_services = csc_get_main_services();

// Exit if no services
if (empty($main_services)) {
    return;
}
?>

<?php
// Get the link from shortcode attribute if available
$directory_base_slug = isset($GLOBALS['csc_current_link']) ? $GLOBALS['csc_current_link'] : 'directory-listing';
?>
<div class="csc-service-carousel" data-directory-base-slug="<?php echo esc_attr($directory_base_slug); ?>">
    <!-- Location Selector and Search -->
    <div class="csc-location-selector">
        <label for="locationSelect" class="csc-location-label">
            <i class="fas fa-map-marker-alt"></i>
            اختر الموقع
        </label>
        <div class="csc-custom-select" id="locationCustomSelect">
            <button type="button" class="csc-custom-select-button" aria-expanded="false" aria-haspopup="listbox">
                <span class="selected-text">-- اختر الموقع --</span>
                <span class="select-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                        <path fill="currentColor" d="M6 9L1 4h10z"/>
                    </svg>
                </span>
            </button>
            <div class="csc-custom-select-dropdown" role="listbox" id="locationSelectDropdown">
                <!-- Options will be dynamically inserted here by JavaScript -->
            </div>
        </div>
        <!-- Hidden native select for form submission and fallback -->
        <select id="locationSelect" class="csc-location-select" style="display: none;" aria-hidden="true">
        </select>
        
        <!-- Service Search Field -->
        <?php echo csc_render_service_search_field(); ?>
    </div>
    
    <!-- Main Categories Grid (4 categories displayed) -->
    <div class="csc-main-categories">
        <?php foreach ($main_services as $service) : ?>
            <a href="#" 
               class="csc-service-box" 
               data-category="<?php echo esc_attr($service['category']); ?>"
               data-url="<?php echo esc_attr($service['url']); ?>">
                <?php
                // Load SVG icons from separate files
                $icon_file = '';
                switch($service['category']) {
                    case 'البناء الذاتي والتشطيب':
                        $icon_file = CSC_PLUGIN_DIR . 'assets/icons/home-user.svg';
                        break;
                    case 'الصيانة والتنظيف':
                        $icon_file = CSC_PLUGIN_DIR . 'assets/icons/tools-reparation.svg';
                        break;
                    case 'الموردين والمواد':
                        $icon_file = CSC_PLUGIN_DIR . 'assets/icons/supply-chain.svg';
                        break;
                    case 'التأجير والخدمات المساندة':
                        $icon_file = CSC_PLUGIN_DIR . 'assets/icons/excavator.svg';
                        break;
                    default:
                        $icon_file = '';
                }
                
                if ($icon_file && file_exists($icon_file)) {
                    $svg_content = file_get_contents($icon_file);
                    // Ensure width and height are set and color is white
                    $svg_content = preg_replace('/<svg([^>]*)>/', '<svg$1 width="30" height="30">', $svg_content);
                    // Force white color for SVG paths - replace all color variations
                    $svg_content = str_replace('fill="#000000"', 'fill="#ffffff"', $svg_content);
                    $svg_content = str_replace('fill="currentColor"', 'fill="#ffffff"', $svg_content);
                    $svg_content = str_replace('fill="none"', 'fill="#ffffff"', $svg_content);
                    $svg_content = str_replace('stroke="#000000"', 'stroke="#ffffff"', $svg_content);
                    $svg_content = str_replace('stroke="currentColor"', 'stroke="#ffffff"', $svg_content);
                    // Replace any remaining black colors
                    $svg_content = preg_replace('/fill="[^"]*black[^"]*"/i', 'fill="#ffffff"', $svg_content);
                    $svg_content = preg_replace('/stroke="[^"]*black[^"]*"/i', 'stroke="#ffffff"', $svg_content);
                    echo $svg_content;
                } else {
                    // Fallback to icon class
                    echo '<i class="' . esc_attr($service['icon']) . '"></i>';
                }
                ?>
                <h4><?php echo esc_html($service['title']); ?></h4>
            </a>
        <?php endforeach; ?>
    </div>
    
    <!-- Secondary Services Container (hidden by default) -->
    <div id="secondaryServices" class="csc-secondary-services" style="display: none;">
        <!-- Secondary services will be dynamically inserted here by JavaScript -->
    </div>
    
    <!-- Third-level Services Container (hidden by default) -->
    <div id="tertiaryServices" class="csc-tertiary-services" style="display: none;">
        <!-- Third-level services will be dynamically inserted here by JavaScript -->
    </div>
    
    <!-- Go Button (hidden by default, shown when services are selected) -->
    <button id="goButton" class="csc-go-button" style="display: none;">
        البحث
    </button>
</div>

