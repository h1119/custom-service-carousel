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

<div class="csc-service-carousel">
    <!-- Location Selector -->
    <div class="csc-location-selector">
        <label for="locationSelect" class="csc-location-label">
            <i class="fas fa-map-marker-alt"></i>
            اختر الموقع
        </label>
        <select id="locationSelect" class="csc-location-select">
            <option value="">-- اختر الموقع --</option>
            <optgroup label="المنطقة الشرقية">
                <option value="الدمام">الدمام</option>
                <option value="الخبر">الخبر</option>
                <option value="الظهران">الظهران</option>
                <option value="القطيف">القطيف</option>
                <option value="الأحساء">الأحساء</option>
                <option value="حفر الباطن">حفر الباطن</option>
                <option value="الجبيل">الجبيل</option>
                <option value="رأس تنورة">رأس تنورة</option>
                <option value="بقيق">بقيق</option>
                <option value="النعيرية">النعيرية</option>
            </optgroup>
            <optgroup label="منطقة الرياض">
                <option value="الرياض">الرياض</option>
                <option value="الخرج">الخرج</option>
                <option value="الدوادمي">الدوادمي</option>
                <option value="المجمعة">المجمعة</option>
                <option value="القويعية">القويعية</option>
                <option value="الأفلاج">الأفلاج</option>
                <option value="وادي الدواسر">وادي الدواسر</option>
                <option value="الزلفي">الزلفي</option>
                <option value="شقراء">شقراء</option>
                <option value="حوطة بني تميم">حوطة بني تميم</option>
            </optgroup>
            <optgroup label="منطقة مكة المكرمة">
                <option value="مكة المكرمة">مكة المكرمة</option>
                <option value="جدة">جدة</option>
                <option value="الطائف">الطائف</option>
                <option value="رابغ">رابغ</option>
                <option value="خليص">خليص</option>
                <option value="القنفذة">القنفذة</option>
                <option value="الليث">الليث</option>
                <option value="أضم">أضم</option>
                <option value="تربة">تربة</option>
                <option value="رنية">رنية</option>
            </optgroup>
            <optgroup label="منطقة المدينة المنورة">
                <option value="المدينة المنورة">المدينة المنورة</option>
                <option value="ينبع">ينبع</option>
                <option value="العلا">العلا</option>
                <option value="المدينة">المدينة</option>
                <option value="بدر">بدر</option>
                <option value="خيبر">خيبر</option>
                <option value="العيص">العيص</option>
                <option value="الحناكية">الحناكية</option>
            </optgroup>
            <optgroup label="منطقة القصيم">
                <option value="بريدة">بريدة</option>
                <option value="عنيزة">عنيزة</option>
                <option value="الرس">الرس</option>
                <option value="المذنب">المذنب</option>
                <option value="البكيرية">البكيرية</option>
                <option value="البدائع">البدائع</option>
                <option value="الأسياح">الأسياح</option>
                <option value="النبهانية">النبهانية</option>
            </optgroup>
            <optgroup label="منطقة عسير">
                <option value="أبها">أبها</option>
                <option value="خميس مشيط">خميس مشيط</option>
                <option value="نجران">نجران</option>
                <option value="جازان">جازان</option>
                <option value="صبيا">صبيا</option>
                <option value="أحد رفيدة">أحد رفيدة</option>
                <option value="محايل عسير">محايل عسير</option>
                <option value="النماص">النماص</option>
                <option value="بلقرن">بلقرن</option>
                <option value="تثليث">تثليث</option>
            </optgroup>
            <optgroup label="منطقة تبوك">
                <option value="تبوك">تبوك</option>
                <option value="الوجه">الوجه</option>
                <option value="ضباء">ضباء</option>
                <option value="تيماء">تيماء</option>
                <option value="أملج">أملج</option>
                <option value="حقل">حقل</option>
            </optgroup>
            <optgroup label="منطقة حائل">
                <option value="حائل">حائل</option>
                <option value="بقعاء">بقعاء</option>
                <option value="الغزالة">الغزالة</option>
                <option value="الشملي">الشملي</option>
            </optgroup>
            <optgroup label="منطقة الحدود الشمالية">
                <option value="عرعر">عرعر</option>
                <option value="طريف">طريف</option>
                <option value="رفحاء">رفحاء</option>
            </optgroup>
            <optgroup label="منطقة الجوف">
                <option value="سكاكا">سكاكا</option>
                <option value="القريات">القريات</option>
                <option value="دومة الجندل">دومة الجندل</option>
            </optgroup>
            <optgroup label="منطقة الباحة">
                <option value="الباحة">الباحة</option>
                <option value="بلجرشي">بلجرشي</option>
                <option value="المندق">المندق</option>
                <option value="المخواة">المخواة</option>
            </optgroup>
            <optgroup label="منطقة جازان">
                <option value="جازان">جازان</option>
                <option value="صبيا">صبيا</option>
                <option value="أبو عريش">أبو عريش</option>
                <option value="صامطة">صامطة</option>
                <option value="بيش">بيش</option>
            </optgroup>
            <optgroup label="منطقة نجران">
                <option value="نجران">نجران</option>
                <option value="شرورة">شرورة</option>
                <option value="حبونا">حبونا</option>
            </optgroup>
        </select>
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
                    case 'صيانة المنازل الدورية':
                        $icon_file = CSC_PLUGIN_DIR . 'assets/icons/tools-reparation.svg';
                        break;
                    case 'الموردين والمواد':
                        $icon_file = CSC_PLUGIN_DIR . 'assets/icons/supply-chain.svg';
                        break;
                    case 'المعدات والخدمات المساندة':
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
    
    <!-- Go Button (hidden by default, shown when services are selected) -->
    <button id="goButton" class="csc-go-button" style="display: none;">
        اذهب
    </button>
</div>

