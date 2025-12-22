<?php
/**
 * Services List Content Template
 * This template is used by the csc_services_list shortcode
 */

if (!defined('ABSPATH')) exit;

// Get all service data
$main_services = csc_get_main_services();
$secondary_services = csc_get_secondary_services();
$tertiary_services = csc_get_tertiary_services();

// Get redirect page from shortcode attribute or use default
$redirect_page = isset($GLOBALS['csc_services_list_redirect_page']) 
    ? sanitize_text_field($GLOBALS['csc_services_list_redirect_page']) 
    : 'directory-listing';
?>

<style>
.csc-services-list-container {
    width: 100%;
    margin: 0;
    padding: 40px 60px;
    direction: rtl;
    box-sizing: border-box;
}

.csc-main-service-section {
    margin-bottom: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    width: 100%;
    box-sizing: border-box;
    overflow: hidden;
}

.csc-main-service-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 25px 40px;
    cursor: pointer;
    user-select: none;
    border-bottom: 2px solid #e0e0e0;
    transition: background-color 0.3s ease;
}

.csc-main-service-header:hover {
    background-color: #f5f5f5;
}

.csc-main-service-header.active {
    border-bottom: none;
}

.csc-main-service-header-content {
    display: flex;
    align-items: center;
    flex: 1;
}

.csc-main-service-header-toggle {
    font-size: 1.5em;
    color: #4a90e2;
    transition: transform 0.3s ease;
    margin-right: 15px;
}

.csc-main-service-header.active .csc-main-service-header-toggle {
    transform: rotate(180deg);
}

.csc-main-service-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease, padding 0.4s ease;
    padding: 0 40px;
}

.csc-main-service-content.active {
    max-height: 10000px;
    padding: 30px 40px;
}

.csc-main-service-header i {
    font-size: 2em;
    margin-left: 15px;
    color: #4a90e2;
}

.csc-main-service-header h2 {
    margin: 0;
    font-size: 1.8em;
    color: #333;
}

.csc-secondary-service-group {
    margin-bottom: 30px;
    padding: 25px;
    background: #f9f9f9;
    border-radius: 8px;
    border-right: 4px solid #4a90e2;
    width: 100%;
    box-sizing: border-box;
}

.csc-secondary-service-title {
    font-size: 1.4em;
    font-weight: bold;
    margin-bottom: 15px;
    color: #555;
    display: flex;
    align-items: center;
}

.csc-secondary-service-title i {
    margin-left: 10px;
    color: #4a90e2;
}

.csc-tertiary-services-list {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 15px;
    margin-top: 15px;
}

.csc-tertiary-service-item {
    background: #fff;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
    text-align: center;
    height: auto;
}

.csc-tertiary-service-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-color: #4a90e2;
}

.csc-tertiary-service-item a {
    text-decoration: none;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 15px;
    height: 100%;
}

.csc-tertiary-service-item i {
    font-size: 1.5em;
    color: #4a90e2;
}

.csc-tertiary-service-item span {
    font-size: 0.95em;
}

/* Secondary services without tertiary - displayed as items */
.csc-secondary-service-item {
    background: #fff;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
    text-align: center;
    height: auto;
}

.csc-secondary-service-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-color: #4a90e2;
}

.csc-secondary-service-item a {
    text-decoration: none;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 15px;
    height: 100%;
}

.csc-secondary-service-item i {
    font-size: 1.5em;
    color: #4a90e2;
}

.csc-secondary-service-item span {
    font-size: 0.95em;
}

/* Group for secondary services without tertiary */
.csc-secondary-no-tertiary-group {
    margin-top: 30px;
    padding: 25px;
    background: #f0f7ff;
    border-radius: 8px;
    border-right: 4px solid #4a90e2;
}

.csc-secondary-no-tertiary-list {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 15px;
}

/* If no tertiary services, show secondary as clickable */
.csc-secondary-service-link {
    display: inline-block;
    padding: 10px 20px;
    background: #4a90e2;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s ease;
    margin-top: 10px;
}

.csc-secondary-service-link:hover {
    background: #357abd;
}

@media (max-width: 1024px) {
    .csc-services-list-container {
        padding: 30px 40px;
    }
    
    .csc-main-service-header {
        padding: 20px 30px;
    }
    
    .csc-main-service-content.active {
        padding: 25px 30px;
    }
    
    .csc-tertiary-services-list,
    .csc-secondary-no-tertiary-list {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 768px) {
    .csc-secondary-no-tertiary-group {
        padding: 15px;
    }
    .csc-services-list-container {
        padding: 20px 15px;
    }
    
    .csc-main-service-header {
        padding: 15px 20px;
    }
    
    .csc-main-service-content.active {
        padding: 20px;
    }
    
    .csc-secondary-service-group {
        padding: 15px;
    }
    
    .csc-main-service-header h2 {
        font-size: 1.4em;
    }
    
    .csc-main-service-header i {
        font-size: 1.5em;
    }
    
    .csc-tertiary-services-list,
    .csc-secondary-no-tertiary-list {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 425px) {
    .csc-tertiary-services-list,
    .csc-secondary-no-tertiary-list {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<div class="csc-services-list-container">
    <?php 
    $loop_index = 0;
    foreach ($main_services as $main_service) : 
        $main_category = $main_service['category'];
        $main_secondary = isset($secondary_services[$main_category]) ? $secondary_services[$main_category] : array();
        // Check for tertiary services - handle category name variations
        $main_tertiary = isset($tertiary_services[$main_category]) ? $tertiary_services[$main_category] : array();
        // Also check for alternative category name for maintenance services
        if ($main_category === 'الصيانة والتنظيف' && empty($main_tertiary)) {
            $alt_category = 'صيانة المنازل الدورية';
            $main_tertiary = isset($tertiary_services[$alt_category]) ? $tertiary_services[$alt_category] : array();
        }
    ?>
        <div class="csc-main-service-section" data-service-index="<?php echo esc_attr($loop_index); ?>">
            <div class="csc-main-service-header" data-service-index="<?php echo esc_attr($loop_index); ?>">
                <div class="csc-main-service-header-content">
                    <i class="<?php echo esc_attr($main_service['icon']); ?>"></i>
                    <h2><?php echo esc_html($main_service['title']); ?></h2>
                </div>
                <span class="csc-main-service-header-toggle">
                    <i class="fas fa-chevron-down"></i>
                </span>
            </div>
            
            <div class="csc-main-service-content" data-service-index="<?php echo esc_attr($loop_index); ?>">
            <?php if (!empty($main_secondary)) : 
                // Separate secondary services into two groups: with tertiary and without
                $secondary_with_tertiary = array();
                $secondary_without_tertiary = array();
                
                foreach ($main_secondary as $secondary) {
                    $secondary_title = $secondary['title'];
                    $secondary_tertiary = isset($main_tertiary[$secondary_title]) ? $main_tertiary[$secondary_title] : array();
                    
                    if (!empty($secondary_tertiary)) {
                        $secondary_with_tertiary[] = $secondary;
                    } else {
                        $secondary_without_tertiary[] = $secondary;
                    }
                }
            ?>
                <!-- Display secondary services WITH tertiary services -->
                <?php foreach ($secondary_with_tertiary as $secondary) : 
                    $secondary_title = $secondary['title'];
                    $secondary_tertiary = isset($main_tertiary[$secondary_title]) ? $main_tertiary[$secondary_title] : array();
                ?>
                    <div class="csc-secondary-service-group">
                        <div class="csc-secondary-service-title">
                            <i class="<?php echo esc_attr($secondary['icon']); ?>"></i>
                            <span><?php echo esc_html($secondary_title); ?></span>
                        </div>
                        
                        <div class="csc-tertiary-services-list">
                            <?php foreach ($secondary_tertiary as $tertiary) : 
                                $tertiary_title = $tertiary['title'];
                                $secondary_id = isset($secondary['id']) ? $secondary['id'] : null;
                                $service_url = csc_get_service_url_list($secondary_id, $tertiary_title, $secondary_title, $redirect_page);
                            ?>
                                <div class="csc-tertiary-service-item">
                                    <a href="<?php echo esc_url($service_url); ?>">
                                        <i class="<?php echo esc_attr($tertiary['icon']); ?>"></i>
                                        <span><?php echo esc_html($tertiary_title); ?></span>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Also provide link to secondary service itself -->
                        <?php 
                        $secondary_id = isset($secondary['id']) ? $secondary['id'] : null;
                        $secondary_url = csc_get_service_url_list($secondary_id, null, null, $redirect_page);
                        ?>
                        <a href="<?php echo esc_url($secondary_url); ?>" class="csc-secondary-service-link">
                            عرض جميع شركات <?php echo esc_html($secondary_title); ?>
                        </a>
                    </div>
                <?php endforeach; ?>
                
                <!-- Display secondary services WITHOUT tertiary services together -->
                <?php if (!empty($secondary_without_tertiary)) : ?>
                    <div class="csc-secondary-no-tertiary-group">
                        <div class="csc-secondary-no-tertiary-list">
                            <?php foreach ($secondary_without_tertiary as $secondary) : 
                                $secondary_title = $secondary['title'];
                                $secondary_id = isset($secondary['id']) ? $secondary['id'] : null;
                                $service_url = csc_get_service_url_list($secondary_id, null, null, $redirect_page);
                            ?>
                                <div class="csc-secondary-service-item">
                                    <a href="<?php echo esc_url($service_url); ?>">
                                        <i class="<?php echo esc_attr($secondary['icon']); ?>"></i>
                                        <span><?php echo esc_html($secondary_title); ?></span>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <!-- If no secondary services, make main service clickable -->
                <!-- Note: Main services don't have IDs, so we'll use a simple directory-listing link -->
                <?php 
                $directory_base_link = trim($redirect_page, '/');
                if (empty($directory_base_link)) {
                    $directory_base_link = 'directory-listing';
                }
                $main_service_url = home_url('/' . $directory_base_link . '/?filter=1&sort=post_published');
                ?>
                <a href="<?php echo esc_url($main_service_url); ?>" class="csc-secondary-service-link">
                    عرض الخدمة
                </a>
            <?php endif; ?>
            </div>
        </div>
    <?php 
        $loop_index++;
        endforeach; 
    ?>
</div>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const serviceHeaders = document.querySelectorAll('.csc-main-service-header');
        const serviceContents = document.querySelectorAll('.csc-main-service-content');
        
        // Keep all sections closed initially (they're already closed by default CSS)
        
        // Add click handlers for accordion functionality
        serviceHeaders.forEach(function(header) {
            header.addEventListener('click', function() {
                const index = this.getAttribute('data-service-index');
                const content = document.querySelector('.csc-main-service-content[data-service-index="' + index + '"]');
                const isActive = this.classList.contains('active');
                
                // Toggle the clicked section
                if (isActive) {
                    this.classList.remove('active');
                    content.classList.remove('active');
                } else {
                    this.classList.add('active');
                    content.classList.add('active');
                }
            });
        });
    });
})();
</script>

