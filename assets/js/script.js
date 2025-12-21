(function($) {
    'use strict';
    
    // Location selection
    let selectedLocation = '';
    let locationData = [];
    
    // Load locations via AJAX
    function loadLocationsAjax() {
        const $locationSelect = $('#locationSelect');
        if (!$locationSelect.length) return;
        
        // Show loading state
        $locationSelect.prop('disabled', true).html('<option value="">جاري التحميل...</option>');
        
        // AJAX request to load locations
        $.ajax({
            url: (typeof cscAjax !== 'undefined' && cscAjax.ajaxurl) ? cscAjax.ajaxurl : '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'csc_get_locations',
                nonce: (typeof cscAjax !== 'undefined' && cscAjax.nonce) ? cscAjax.nonce : ''
            },
            dataType: 'json',
            success: function(response) {
                $locationSelect.prop('disabled', false);
                
                if (response && response.success && response.data && response.data.locations) {
                    locationData = response.data.locations;
                    populateLocationSelect($locationSelect, locationData);
                    
                    // Rebuild custom select after locations are loaded
                    if (typeof initCustomSelect === 'function') {
                        setTimeout(initCustomSelect, 50);
                    }
                    
                    // Load saved location after populating
                    const savedLocation = localStorage.getItem('csc_selected_location');
                    if (savedLocation) {
                        $locationSelect.val(savedLocation);
                        selectedLocation = savedLocation;
                        
                        // Update custom select display
                        const $selectedTextSpan = $('#locationCustomSelect .csc-custom-select-button .selected-text');
                        if ($selectedTextSpan.length) {
                            const $selectedOption = $locationSelect.find('option:selected');
                            $selectedTextSpan.text($selectedOption.length ? $selectedOption.text() : savedLocation);
                        }
                    }
                } else {
                    // Fallback: use default locations if AJAX fails
                    console.warn('AJAX failed, using default locations');
                    loadDefaultLocations($locationSelect);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', status, error);
                $locationSelect.prop('disabled', false);
                loadDefaultLocations($locationSelect);
            }
        });
    }
    
    // Populate location select with data
    function populateLocationSelect($select, locations) {
        $select.html('<option value="">-- اختر الموقع --</option>');
        
        // Group locations by region
        const regions = {};
        $.each(locations, function(index, location) {
            const region = location.region || 'أخرى';
            if (!regions[region]) {
                regions[region] = [];
            }
            regions[region].push(location);
        });
        
        // Create optgroups (sorted by region name)
        const sortedRegions = Object.keys(regions).sort();
        $.each(sortedRegions, function(index, region) {
            const $optgroup = $('<optgroup>').attr('label', region);
            const regionLocations = regions[region];
            
            $.each(regionLocations, function(index, location) {
                const $option = $('<option>')
                    .attr('value', location.name)
                    .text(location.name);
                $optgroup.append($option);
            });
            
            $select.append($optgroup);
        });
    }
    
    // Fallback: Load default locations if AJAX fails
    function loadDefaultLocations($select) {
        const defaultLocations = [
            {region: 'المنطقة الشرقية', name: 'الدمام'},
            {region: 'المنطقة الشرقية', name: 'الخبر'},
            {region: 'المنطقة الشرقية', name: 'الظهران'},
            {region: 'المنطقة الشرقية', name: 'القطيف'},
            {region: 'المنطقة الشرقية', name: 'الأحساء'},
            {region: 'المنطقة الشرقية', name: 'حفر الباطن'},
            {region: 'المنطقة الشرقية', name: 'الجبيل'},
            {region: 'المنطقة الشرقية', name: 'رأس تنورة'},
            {region: 'المنطقة الشرقية', name: 'بقيق'},
            {region: 'المنطقة الشرقية', name: 'النعيرية'},
            {region: 'منطقة الرياض', name: 'الرياض'},
            {region: 'منطقة الرياض', name: 'الخرج'},
            {region: 'منطقة الرياض', name: 'الدوادمي'},
            {region: 'منطقة الرياض', name: 'المجمعة'},
            {region: 'منطقة الرياض', name: 'القويعية'},
            {region: 'منطقة الرياض', name: 'الأفلاج'},
            {region: 'منطقة الرياض', name: 'وادي الدواسر'},
            {region: 'منطقة الرياض', name: 'الزلفي'},
            {region: 'منطقة الرياض', name: 'شقراء'},
            {region: 'منطقة الرياض', name: 'حوطة بني تميم'},
            {region: 'منطقة مكة المكرمة', name: 'مكة المكرمة'},
            {region: 'منطقة مكة المكرمة', name: 'جدة'},
            {region: 'منطقة مكة المكرمة', name: 'الطائف'},
            {region: 'منطقة مكة المكرمة', name: 'رابغ'},
            {region: 'منطقة مكة المكرمة', name: 'خليص'},
            {region: 'منطقة مكة المكرمة', name: 'القنفذة'},
            {region: 'منطقة مكة المكرمة', name: 'الليث'},
            {region: 'منطقة مكة المكرمة', name: 'أضم'},
            {region: 'منطقة مكة المكرمة', name: 'تربة'},
            {region: 'منطقة مكة المكرمة', name: 'رنية'},
            {region: 'منطقة المدينة المنورة', name: 'المدينة المنورة'},
            {region: 'منطقة المدينة المنورة', name: 'ينبع'},
            {region: 'منطقة المدينة المنورة', name: 'العلا'},
            {region: 'منطقة المدينة المنورة', name: 'المدينة'},
            {region: 'منطقة المدينة المنورة', name: 'بدر'},
            {region: 'منطقة المدينة المنورة', name: 'خيبر'},
            {region: 'منطقة المدينة المنورة', name: 'العيص'},
            {region: 'منطقة المدينة المنورة', name: 'الحناكية'},
            {region: 'منطقة القصيم', name: 'بريدة'},
            {region: 'منطقة القصيم', name: 'عنيزة'},
            {region: 'منطقة القصيم', name: 'الرس'},
            {region: 'منطقة القصيم', name: 'المذنب'},
            {region: 'منطقة القصيم', name: 'البكيرية'},
            {region: 'منطقة القصيم', name: 'البدائع'},
            {region: 'منطقة القصيم', name: 'الأسياح'},
            {region: 'منطقة القصيم', name: 'النبهانية'},
            {region: 'منطقة عسير', name: 'أبها'},
            {region: 'منطقة عسير', name: 'خميس مشيط'},
            {region: 'منطقة عسير', name: 'نجران'},
            {region: 'منطقة عسير', name: 'جازان'},
            {region: 'منطقة عسير', name: 'صبيا'},
            {region: 'منطقة عسير', name: 'أحد رفيدة'},
            {region: 'منطقة عسير', name: 'محايل عسير'},
            {region: 'منطقة عسير', name: 'النماص'},
            {region: 'منطقة عسير', name: 'بلقرن'},
            {region: 'منطقة عسير', name: 'تثليث'},
            {region: 'منطقة تبوك', name: 'تبوك'},
            {region: 'منطقة تبوك', name: 'الوجه'},
            {region: 'منطقة تبوك', name: 'ضباء'},
            {region: 'منطقة تبوك', name: 'تيماء'},
            {region: 'منطقة تبوك', name: 'أملج'},
            {region: 'منطقة تبوك', name: 'حقل'},
            {region: 'منطقة حائل', name: 'حائل'},
            {region: 'منطقة حائل', name: 'بقعاء'},
            {region: 'منطقة حائل', name: 'الغزالة'},
            {region: 'منطقة حائل', name: 'الشملي'},
            {region: 'منطقة الحدود الشمالية', name: 'عرعر'},
            {region: 'منطقة الحدود الشمالية', name: 'طريف'},
            {region: 'منطقة الحدود الشمالية', name: 'رفحاء'},
            {region: 'منطقة الجوف', name: 'سكاكا'},
            {region: 'منطقة الجوف', name: 'القريات'},
            {region: 'منطقة الجوف', name: 'دومة الجندل'},
            {region: 'منطقة الباحة', name: 'الباحة'},
            {region: 'منطقة الباحة', name: 'بلجرشي'},
            {region: 'منطقة الباحة', name: 'المندق'},
            {region: 'منطقة الباحة', name: 'المخواة'},
            {region: 'منطقة جازان', name: 'جازان'},
            {region: 'منطقة جازان', name: 'صبيا'},
            {region: 'منطقة جازان', name: 'أبو عريش'},
            {region: 'منطقة جازان', name: 'صامطة'},
            {region: 'منطقة جازان', name: 'بيش'},
            {region: 'منطقة نجران', name: 'نجران'},
            {region: 'منطقة نجران', name: 'شرورة'},
            {region: 'منطقة نجران', name: 'حبونا'},
        ];
        
        populateLocationSelect($select, defaultLocations);
        
        // Rebuild custom select after locations are loaded
        if (typeof initCustomSelect === 'function') {
            setTimeout(initCustomSelect, 50);
        }
        
        // Load saved location
        const savedLocation = localStorage.getItem('csc_selected_location');
        if (savedLocation) {
            $select.val(savedLocation);
            selectedLocation = savedLocation;
            
            // Update custom select display
            const $selectedTextSpan = $('#locationCustomSelect .csc-custom-select-button .selected-text');
            if ($selectedTextSpan.length) {
                const $selectedOption = $select.find('option:selected');
                $selectedTextSpan.text($selectedOption.length ? $selectedOption.text() : savedLocation);
            }
        }
    }
    
    // Initialize Custom Select Component
    function initCustomSelect() {
        const $locationSelect = $('#locationSelect');
        const $customSelectContainer = $('#locationCustomSelect');
        const $customSelectButton = $customSelectContainer.find('.csc-custom-select-button');
        const $customSelectDropdown = $('#locationSelectDropdown');
        const $selectedTextSpan = $customSelectButton.find('.selected-text');

        if (!$locationSelect.length || !$customSelectContainer.length || !$customSelectButton.length || !$customSelectDropdown.length || !$selectedTextSpan.length) {
            console.warn('Custom select elements not found');
            return;
        }

        // Update selected text display
        function updateSelectedText() {
            const $selectedOption = $locationSelect.find('option:selected');
            if ($selectedOption.length && $selectedOption.val()) {
                $selectedTextSpan.text($selectedOption.text());
            } else {
                $selectedTextSpan.text('-- اختر الموقع --');
            }
        }

        // Build custom select dropdown from native select
        function buildCustomSelect() {
            $customSelectDropdown.empty();
            
            const $optgroups = $locationSelect.find('optgroup');
            const $standaloneOptions = $locationSelect.find('> option').filter(function() {
                return !$(this).closest('optgroup').length;
            });

            // Add standalone options first
            $standaloneOptions.each(function() {
                const $option = $(this);
                if (!$option.val() || $option.val() === '-- اختر الموقع --') return;
                
                const $optionEl = $('<div>')
                    .addClass('csc-select-option')
                    .attr('role', 'option')
                    .attr('tabindex', '0')
                    .attr('data-value', $option.val())
                    .text($option.text());
                
                if ($locationSelect.val() === $option.val()) {
                    $optionEl.addClass('selected');
                }
                
                $optionEl.on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    selectOption($option.val(), $option.text());
                });
                
                $customSelectDropdown.append($optionEl);
            });

            // Add optgroups with titles
            $optgroups.each(function() {
                const $optgroup = $(this);
                
                // Add group title
                const $groupTitle = $('<div>')
                    .addClass('csc-select-group')
                    .text($optgroup.attr('label'));
                $customSelectDropdown.append($groupTitle);

                // Add options in this group
                $optgroup.find('option').each(function() {
                    const $option = $(this);
                    const $optionEl = $('<div>')
                        .addClass('csc-select-option')
                        .attr('role', 'option')
                        .attr('tabindex', '0')
                        .attr('data-value', $option.val())
                        .text($option.text());
                    
                    if ($locationSelect.val() === $option.val()) {
                        $optionEl.addClass('selected');
                    }
                    
                    $optionEl.on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        selectOption($option.val(), $option.text());
                    });
                    
                    $customSelectDropdown.append($optionEl);
                });
            });
        }

        // Select an option
        function selectOption(value, text) {
            // Close dropdown first
            closeDropdown();
            
            // Update native select
            $locationSelect.val(value);
            
            // Update custom select button text
            $selectedTextSpan.text(text || '-- اختر الموقع --');
            
            // Update selected location
            selectedLocation = value;
            localStorage.setItem('csc_selected_location', selectedLocation);
            
            // Trigger change event on native select
            $locationSelect.trigger('change');
            
            // Rebuild dropdown after a delay to ensure dropdown is fully closed
            setTimeout(function() {
                buildCustomSelect();
                // Update selected state after rebuild
                $customSelectDropdown.find('.csc-select-option').each(function() {
                    const $opt = $(this);
                    $opt.removeClass('selected');
                    if ($opt.attr('data-value') === value) {
                        $opt.addClass('selected');
                    }
                });
            }, 150);
        }

        // Open dropdown
        function openDropdown() {
            $customSelectButton.addClass('active').attr('aria-expanded', 'true');
            $customSelectDropdown.addClass('show');
        }

        // Close dropdown
        function closeDropdown() {
            $customSelectButton.removeClass('active').attr('aria-expanded', 'false');
            $customSelectDropdown.removeClass('show');
        }

        // Flag to track if dropdown is being toggled
        let isToggling = false;

        // Toggle dropdown
        $customSelectButton.on('click.customSelect', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            isToggling = true;
            
            // Toggle: close if open, open if closed
            if ($customSelectButton.hasClass('active')) {
                closeDropdown();
            } else {
                openDropdown();
            }
            
            // Reset flag after a short delay
            setTimeout(function() {
                isToggling = false;
            }, 200);
            
            return false;
        });

        // Close dropdown when clicking outside
        $(document).on('click.customSelectClose', function(e) {
            const $target = $(e.target);
            
            // Don't close if we're toggling
            if (isToggling) {
                return;
            }
            
            // Don't close if click is on the button or inside the container
            if ($target.closest($customSelectButton).length || 
                $target.closest($customSelectContainer).length) {
                return;
            }
            
            // Close if click is outside
            closeDropdown();
        });

        // Close dropdown on Escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $customSelectButton.hasClass('active')) {
                closeDropdown();
            }
        });

        // Keyboard navigation - use event delegation
        $(document).on('keydown', '#locationSelectDropdown .csc-select-option', function(e) {
            const $options = $customSelectDropdown.find('.csc-select-option');
            const currentIndex = $options.index(this);
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    e.stopPropagation();
                    const nextIndex = currentIndex < $options.length - 1 ? currentIndex + 1 : 0;
                    $options.eq(nextIndex).focus();
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    e.stopPropagation();
                    const prevIndex = currentIndex > 0 ? currentIndex - 1 : $options.length - 1;
                    $options.eq(prevIndex).focus();
                    break;
                case 'Enter':
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).trigger('click');
                    break;
            }
        });

        // Initialize dropdown content
        buildCustomSelect();
        updateSelectedText();

        // Watch for changes in native select
        $locationSelect.on('change.customSelect', function() {
            updateSelectedText();
        });

        // Watch for DOM changes (when options are added/removed)
        let isRebuilding = false;
        const observer = new MutationObserver(function() {
            // Prevent multiple simultaneous rebuilds
            if (!isRebuilding && !$customSelectButton.hasClass('active')) {
                isRebuilding = true;
                buildCustomSelect();
                updateSelectedText();
                setTimeout(function() {
                    isRebuilding = false;
                }, 100);
            }
        });

        if ($locationSelect[0]) {
            observer.observe($locationSelect[0], {
                childList: true,
                subtree: true
            });
        }
    }

    // Initialize location selector
    function initLocationSelector() {
        const $locationSelect = $('#locationSelect');
        if ($locationSelect.length) {
            // Try to load via AJAX first (for WordPress)
            if (typeof cscAjax !== 'undefined' && cscAjax.ajaxurl) {
                loadLocationsAjax();
            } else {
                // Fallback to default locations (for local testing)
                loadDefaultLocations($locationSelect);
            }
            
            // Initialize custom select after a short delay to ensure DOM is ready
            setTimeout(function() {
                initCustomSelect();
            }, 100);
            
            // Handle location change
            $locationSelect.on('change', function(e) {
                selectedLocation = $(this).val();
                localStorage.setItem('csc_selected_location', selectedLocation);
            });
        }
    }
    
    // Initialize on document ready
    $(document).ready(function() {
        initLocationSelector();
        initServices();
    });
    
    function initServices() {
        // Check if service container exists on the page
        const $carousel = $('.csc-service-carousel');
        if (!$carousel.length) {
            return;
        }
        
        // Get elements
        const $secondaryServicesContainer = $('#secondaryServices');
        const $tertiaryServicesContainer = $('#tertiaryServices');
        const $goButton = $('#goButton');

        // Check if required elements exist
        if (!$secondaryServicesContainer.length) {
            return;
        }
        
        if (!$goButton.length) {
            return;
        }
        
        if (!$tertiaryServicesContainer.length) {
            return;
        }
        // Check if cscData is available
        if (typeof cscData === 'undefined' || !cscData || !cscData.secondaryServices) {
            console.error("cscData is not defined. Make sure the plugin is properly configured.");
            return;
        }

        // Track selected secondary service (single selection only)
        let selectedSecondaryService = null;
        let selectedSecondaryServiceId = null;
        // Track selected tertiary services (multiselect)
        let selectedTertiaryServices = new Set();

        // Helper function to scroll to element smoothly within its container
        function scrollToElement($element, offset) {
            if (!$element || !$element.length) return;
            
            // Check if element is inside secondary or tertiary services container
            const $secondaryContainer = $element.closest('#secondaryServices');
            const $tertiaryContainer = $element.closest('#tertiaryServices');
            
            if ($secondaryContainer.length) {
                // Scroll horizontally within secondary services container
                const containerLeft = $secondaryContainer.offset().left;
                const containerScrollLeft = $secondaryContainer.scrollLeft();
                const elementLeft = $element.offset().left;
                const elementWidth = $element.outerWidth();
                const containerWidth = $secondaryContainer.outerWidth();
                
                // Calculate scroll position to center the element
                const scrollPosition = containerScrollLeft + (elementLeft - containerLeft) - (containerWidth / 2) + (elementWidth / 2);
                
                $secondaryContainer.animate({
                    scrollLeft: scrollPosition
                }, 500);
            } else if ($tertiaryContainer.length) {
                // Scroll horizontally within tertiary services container
                const containerLeft = $tertiaryContainer.offset().left;
                const containerScrollLeft = $tertiaryContainer.scrollLeft();
                const elementLeft = $element.offset().left;
                const elementWidth = $element.outerWidth();
                const containerWidth = $tertiaryContainer.outerWidth();
                
                // Calculate scroll position to center the element
                const scrollPosition = containerScrollLeft + (elementLeft - containerLeft) - (containerWidth / 2) + (elementWidth / 2);
                
                $tertiaryContainer.animate({
                    scrollLeft: scrollPosition
                }, 500);
            } else {
                // Fallback: scroll page vertically if not in a container
                offset = offset || 100;
                const elementTop = $element.offset().top;
                const offsetPosition = elementTop - offset;

                $('html, body').animate({
                    scrollTop: offsetPosition
                }, 500);
            }
        }

        // Handle Go button clicks
        $goButton.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (!selectedSecondaryService && selectedTertiaryServices.size === 0) {
                alert("يرجى اختيار خدمة فرعية أولاً");
                return;
            }

            const $selectedMainService = $carousel.find(".csc-service-box.marked");
            if (!$selectedMainService.length) {
                alert("يرجى اختيار خدمة رئيسية أولاً");
                return;
            }

            const selectedCategory = $selectedMainService.attr("data-category");
            const baseUrl = $selectedMainService.attr("data-url");

            if (!selectedCategory || !baseUrl) {
                alert("تعذر تحديد الخدمة. حاول مرة أخرى.");
                return;
            }

            updateURL(baseUrl, selectedCategory);
        });

        // Function to update URL
        function updateURL(baseUrl, category) {
            // Validate inputs
            if (!baseUrl || !category) {
                console.error("Missing baseUrl or category");
                return;
            }

            // Create a properly formatted URL
            try {
                const safeBase = String(baseUrl).replace(/^\/+|\/+$/g, '');
                const origin = window.location.origin || (window.location.protocol + '//' + window.location.host);
                // Get baseSlug from carousel data attribute, cscData, or default to 'directory-listing'
                let baseSlug = 'directory-listing';
                if ($carousel.length && $carousel.attr('data-directory-base-slug')) {
                    baseSlug = $carousel.attr('data-directory-base-slug');
                } else if (typeof cscData !== 'undefined' && cscData.directoryBaseSlug) {
                    baseSlug = cscData.directoryBaseSlug;
                }
                const url = new URL(origin + '/' + baseSlug.replace(/^\/+|\/+$/g, '') + '/');

                if (selectedLocation.length) {
                    url.searchParams.append("filter_location_address[text]", selectedLocation);
                }

                // Extract numeric ID from secondary service ID if available
                let categoryId = category;
                if (selectedSecondaryServiceId) {
                    // Extract numeric part from ID like 'secondary-service-83' -> '83'
                    const idMatch = selectedSecondaryServiceId.match(/\d+$/);
                    if (idMatch) {
                        categoryId = idMatch[0];
                    }
                }

                url.searchParams.append("filter_directory_category", categoryId);

                // Add selected tertiary services to the appropriate filter field (dynamic based on secondary service)
                if (selectedTertiaryServices.size > 0 && selectedSecondaryService) {
                    // Get the filter field slug for the selected secondary service
                    let filterFieldSlug = 'filter_field_constarcion'; // Default fallback
                    if (typeof cscData !== 'undefined' && cscData.filterFieldMapping && cscData.filterFieldMapping[selectedSecondaryService]) {
                        filterFieldSlug = cscData.filterFieldMapping[selectedSecondaryService];
                    }
                    
                    selectedTertiaryServices.forEach(function(tertiaryService) {
                        url.searchParams.append(filterFieldSlug + "[]", tertiaryService);
                    });
                } 

                // Add additional fixed query parameters
                url.searchParams.append("filter", "1");
                url.searchParams.append("sort", "post_published");


                // Redirect to the final URL
                let finalUrl = url.toString();
                finalUrl = finalUrl.replace(/\+/g, '%20');
                
                window.location.href = finalUrl;
            } catch (error) {
                console.error("Error building URL:", error);
                alert("حدث خطأ في بناء الرابط. يرجى المحاولة مرة أخرى.");
            }
        }
        
        // Use event delegation for main service boxes
        $carousel.on("click", ".csc-main-categories .csc-service-box", function(e) {
            e.preventDefault();
            const $serviceBox = $(this);
            const category = $serviceBox.attr("data-category");
            const url = $serviceBox.attr("data-url");

            // Deselect all main categories
            $carousel.find(".csc-main-categories .csc-service-box").removeClass("marked");

            // Select the clicked main category
            if (category) {
                $serviceBox.addClass("marked");
                
                // Check if this category has secondary services
                if (cscData.secondaryServices[category]) {
                    // Display secondary services container
                    $secondaryServicesContainer.css("display", "flex");
                    // Reset selected secondary service for the new category
                    selectedSecondaryService = null;
                    selectedSecondaryServiceId = null;
                    selectedTertiaryServices = new Set();
                    $tertiaryServicesContainer.hide();
                    $goButton.hide();
                    $secondaryServicesContainer.empty();
                    $tertiaryServicesContainer.empty();

                    // Display secondary services
                    $.each(cscData.secondaryServices[category], function(index, service) {
                        const $serviceBoxEl = $('<a>')
                            .addClass('csc-service-box')
                            .attr('href', '#')
                            .attr('id', service.id || '')
                            .html('<i class="' + service.icon + '"></i><h4>' + service.title + '</h4>');

                        // Check if this secondary service has tertiary services
                        const hasTertiaryServices = cscData.tertiaryServices && 
                                                    cscData.tertiaryServices[category] && 
                                                    cscData.tertiaryServices[category][service.title];

                        // Add click event to select the service (single selection)
                        $serviceBoxEl.on("click", function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            // If clicking the same service, deselect it
                            if ($(this).hasClass("marked")) {
                                $(this).removeClass("marked");
                                selectedSecondaryService = null;
                                selectedSecondaryServiceId = null;
                                selectedTertiaryServices = new Set();
                                $tertiaryServicesContainer.hide().empty();
                                $goButton.hide();
                            } else {
                                // Deselect all other services
                                $secondaryServicesContainer.find('.csc-service-box').removeClass("marked");
                                // Select this service
                                $(this).addClass("marked");
                                selectedSecondaryService = service.title;
                                    selectedSecondaryServiceId = service.id || null;
                                
                                // Scroll to the selected secondary service
                                const $selectedSecondaryBox = $(this);
                                setTimeout(function() {
                                    scrollToElement($selectedSecondaryBox, 150);
                                }, 100);
                                
                                // Check if this service has tertiary services
                                if (hasTertiaryServices) {
                                    // Show tertiary services (multiselect)
                                    selectedTertiaryServices = new Set();
                                    $tertiaryServicesContainer.css("display", "flex").empty();
                                    
                                    const tertiaryServices = cscData.tertiaryServices[category][service.title];
                                    $.each(tertiaryServices, function(idx, tertiaryService) {
                                        const $tertiaryBoxEl = $('<a>')
                                            .addClass('csc-service-box')
                                            .attr('href', '#')
                                            .html('<i class="' + tertiaryService.icon + '"></i><h4>' + tertiaryService.title + '</h4>');
                                        
                                        // Add click event for multiselect
                                        $tertiaryBoxEl.on("click", function(e) {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            
                                            // Toggle selection
                                            $(this).toggleClass("marked");
                                            
                                            if ($(this).hasClass("marked")) {
                                                selectedTertiaryServices.add(tertiaryService.title);
                                                // Scroll to the selected tertiary service
                                                const $selectedTertiaryBox = $(this);
                                                setTimeout(function() {
                                                    scrollToElement($selectedTertiaryBox, 150);
                                                }, 100);
                                            } else {
                                                selectedTertiaryServices.delete(tertiaryService.title);
                                            }
                                            
                                            // Show/hide Go button based on selections
                                            if (selectedTertiaryServices.size > 0 || selectedSecondaryService) {
                                                $goButton.show();
                                            } else {
                                                $goButton.hide();
                                            }
                                        });
                                        
                                        $tertiaryServicesContainer.append($tertiaryBoxEl);
                                    });
                                } else {
                                    // No tertiary services - just select the secondary service
                                    $tertiaryServicesContainer.hide().empty();
                                    selectedTertiaryServices = new Set();
                                    $goButton.show();
                                }
                            }
                        });

                        $secondaryServicesContainer.append($serviceBoxEl);
                    });
                } else {
                    // For categories without secondary services, navigate directly
                    selectedSecondaryService = null;
                    selectedSecondaryServiceId = null;
                    selectedTertiaryServices = new Set();
                    $secondaryServicesContainer.hide();
                    $tertiaryServicesContainer.hide();
                    $goButton.hide();
                    updateURL(url, category);
                }
            }
        });

        // Click outside handler - REMOVED: Choices will remain visible when clicking outside

        // Function to load selections from URL parameters
        function loadSelectionsFromURL() {
            try {
                const urlParams = new URLSearchParams(window.location.search);
                const filterDirectoryCategory = urlParams.get('filter_directory_category');

                // If no URL parameters, exit
                if (!filterDirectoryCategory) {
                    return;
                }

                // Find the secondary service that matches this category ID
                let foundCategory = null;
                let foundSecondaryService = null;

                // Search through all categories and their secondary services
                for (const category in cscData.secondaryServices) {
                    const secondaryServices = cscData.secondaryServices[category];
                    for (let i = 0; i < secondaryServices.length; i++) {
                        const service = secondaryServices[i];
                        if (service.id) {
                            // Extract numeric ID from service ID (e.g., 'secondary-service-83' -> '83')
                            const idMatch = service.id.match(/\d+$/);
                            if (idMatch && idMatch[0] === filterDirectoryCategory) {
                                foundCategory = category;
                                foundSecondaryService = service;
                                break;
                            }
                        }
                    }
                    if (foundCategory) break;
                }

                // If we found a matching secondary service
                if (foundCategory && foundSecondaryService) {
                    // Get the filter field slug for this secondary service
                    let filterFieldSlug = 'filter_field_constarcion'; // Default fallback
                    if (typeof cscData !== 'undefined' && cscData.filterFieldMapping && cscData.filterFieldMapping[foundSecondaryService.title]) {
                        filterFieldSlug = cscData.filterFieldMapping[foundSecondaryService.title];
                    }
                    
                    // Read tertiary services from the appropriate filter field parameter
                    const filterFieldTertiaryServices = urlParams.getAll(filterFieldSlug + '[]');

                    // Find and click the main category
                    const $mainCategoryBox = $carousel.find(".csc-main-categories .csc-service-box[data-category='" + foundCategory + "']");
                    if ($mainCategoryBox.length) {
                        // Trigger click on main category to show secondary services
                        $mainCategoryBox.trigger('click');

                        // Wait for secondary services to be rendered, then select the matching one
                        setTimeout(function() {
                            const $secondaryServiceBox = $secondaryServicesContainer.find('#' + foundSecondaryService.id);
                            if ($secondaryServiceBox.length) {
                                // Select the secondary service
                                $secondaryServiceBox.trigger('click');

                                // If there are tertiary services to select
                                if (filterFieldTertiaryServices.length > 0) {
                                    // Wait for tertiary services to be rendered
                                    setTimeout(function() {
                                        filterFieldTertiaryServices.forEach(function(tertiaryTitle) {
                                            // Find and click matching tertiary service
                                            $tertiaryServicesContainer.find('.csc-service-box').each(function() {
                                                const $tertiaryBox = $(this);
                                                const tertiaryText = $tertiaryBox.find('h4').text().trim();
                                                if (tertiaryText === tertiaryTitle) {
                                                    if (!$tertiaryBox.hasClass('marked')) {
                                                        $tertiaryBox.trigger('click');
                                                    }
                                                }
                                            });
                                        });
                                    }, 300);
                                }
                            }
                        }, 300);
                    }
                }
            } catch (error) {
                console.error("Error loading selections from URL:", error);
            }
        }

        // Load selections from URL on page load (after a short delay to ensure DOM is ready)
        setTimeout(function() {
            loadSelectionsFromURL();
        }, 100);

        // Initialize Service Search
        function initServiceSearch() {
            const $searchInput = $('#serviceSearchInput');
            const $searchDropdown = $('#serviceSearchDropdown');
            const $searchContainer = $('#serviceSearchContainer');

            if (!$searchInput.length || !$searchDropdown.length) {
                return;
            }

            // Build a flat list of all services for searching
            function buildServiceList() {
                const serviceList = [];

                // Add main services
                $carousel.find('.csc-main-categories .csc-service-box').each(function() {
                    const $box = $(this);
                    // Try to get icon from the box (could be SVG or icon class)
                    let icon = 'fas fa-circle';
                    const $icon = $box.find('i');
                    if ($icon.length) {
                        icon = $icon.attr('class') || 'fas fa-circle';
                    }
                    serviceList.push({
                        type: 'main',
                        title: $box.find('h4').text().trim(),
                        category: $box.attr('data-category'),
                        url: $box.attr('data-url'),
                        icon: icon,
                        element: $box
                    });
                });

                // Add secondary services from cscData
                if (cscData && cscData.secondaryServices) {
                    for (const category in cscData.secondaryServices) {
                        const secondaryServices = cscData.secondaryServices[category];
                        secondaryServices.forEach(function(service) {
                            serviceList.push({
                                type: 'secondary',
                                title: service.title,
                                category: category,
                                serviceId: service.id,
                                icon: service.icon,
                                element: null // Will be set when rendered
                            });
                        });
                    }
                }

                // Add tertiary services from cscData
                if (cscData && cscData.tertiaryServices) {
                    for (const category in cscData.tertiaryServices) {
                        const categoryTertiary = cscData.tertiaryServices[category];
                        for (const secondaryTitle in categoryTertiary) {
                            const tertiaryServices = categoryTertiary[secondaryTitle];
                            tertiaryServices.forEach(function(service) {
                                serviceList.push({
                                    type: 'tertiary',
                                    title: service.title,
                                    category: category,
                                    secondaryTitle: secondaryTitle,
                                    icon: service.icon,
                                    element: null // Will be set when rendered
                                });
                            });
                        }
                    }
                }

                return serviceList;
            }

            const allServices = buildServiceList();

            // Filter services based on search text
            function filterServices(searchText) {
                if (!searchText || searchText.trim() === '') {
                    return [];
                }

                const searchLower = searchText.toLowerCase().trim();
                return allServices.filter(function(service) {
                    return service.title.toLowerCase().includes(searchLower);
                });
            }

            // Display search results
            function displaySearchResults(results) {
                $searchDropdown.empty();

                if (results.length === 0) {
                    $searchDropdown.append(
                        $('<div>').addClass('csc-search-no-results').text('لا توجد نتائج')
                    );
                    $searchDropdown.show();
                    return;
                }

                // Limit results to 10 for better UX
                const limitedResults = results.slice(0, 10);

                limitedResults.forEach(function(service) {
                    let displayText = service.title;
                    if (service.type === 'secondary') {
                        displayText = service.category + ' > ' + service.title;
                    } else if (service.type === 'tertiary') {
                        displayText = service.category + ' > ' + service.secondaryTitle + ' > ' + service.title;
                    }

                    const $resultItem = $('<div>')
                        .addClass('csc-search-result-item')
                        .attr('data-service-type', service.type)
                        .html('<i class="' + (service.icon || 'fas fa-circle') + '"></i><span>' + displayText + '</span>');

                    // Store service data
                    $resultItem.data('service', service);

                    $resultItem.on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        selectServiceFromSearch(service);
                    });

                    $searchDropdown.append($resultItem);
                });

                $searchDropdown.show();
            }

            // Select service from search results
            function selectServiceFromSearch(service) {
                // Hide search dropdown and clear input
                $searchDropdown.hide();
                $searchInput.val('');

                if (service.type === 'main') {
                    // Click the main category
                    const $mainBox = $carousel.find('.csc-main-categories .csc-service-box[data-category="' + service.category + '"]');
                    if ($mainBox.length) {
                        $mainBox.trigger('click');
                    }
                } else if (service.type === 'secondary') {
                    // Find and click the main category first, then the secondary service
                    const $mainBox = $carousel.find('.csc-main-categories .csc-service-box[data-category="' + service.category + '"]');
                    if ($mainBox.length) {
                        $mainBox.trigger('click');
                        // Wait for secondary services to render, then click the matching one
                        setTimeout(function() {
                            const $secondaryBox = $secondaryServicesContainer.find('#' + service.serviceId);
                            if ($secondaryBox.length) {
                                $secondaryBox.trigger('click');
                                // Scroll to the selected secondary service
                                setTimeout(function() {
                                    scrollToElement($secondaryBox, 150);
                                }, 150);
                            }
                        }, 300);
                    }
                } else if (service.type === 'tertiary') {
                    // Find main category, then secondary, then tertiary
                    const $mainBox = $carousel.find('.csc-main-categories .csc-service-box[data-category="' + service.category + '"]');
                    if ($mainBox.length) {
                        $mainBox.trigger('click');
                        // Wait for secondary services to render
                        setTimeout(function() {
                            // Find the secondary service by title
                            let $secondaryBox = null;
                            $secondaryServicesContainer.find('.csc-service-box').each(function() {
                                if ($(this).find('h4').text().trim() === service.secondaryTitle) {
                                    $secondaryBox = $(this);
                                    return false; // break
                                }
                            });
                            if ($secondaryBox && $secondaryBox.length) {
                                $secondaryBox.trigger('click');
                                // Wait for tertiary services to render
                                setTimeout(function() {
                                    // Find and click the tertiary service
                                    let $tertiaryBox = null;
                                    $tertiaryServicesContainer.find('.csc-service-box').each(function() {
                                        if ($(this).find('h4').text().trim() === service.title) {
                                            $tertiaryBox = $(this);
                                            $(this).trigger('click');
                                            return false; // break
                                        }
                                    });
                                    // Scroll to the selected tertiary service
                                    if ($tertiaryBox && $tertiaryBox.length) {
                                        setTimeout(function() {
                                            scrollToElement($tertiaryBox, 150);
                                        }, 150);
                                    }
                                }, 300);
                            }
                        }, 300);
                    }
                }
            }

            // Handle search input
            let searchTimeout;
            $searchInput.on('input', function() {
                const searchText = $(this).val();
                clearTimeout(searchTimeout);
                
                if (searchText.trim() === '') {
                    $searchDropdown.hide();
                    return;
                }

                searchTimeout = setTimeout(function() {
                    const results = filterServices(searchText);
                    displaySearchResults(results);
                }, 200);
            });

            // Handle focus
            $searchInput.on('focus', function() {
                const searchText = $(this).val();
                if (searchText.trim() !== '') {
                    const results = filterServices(searchText);
                    displaySearchResults(results);
                }
            });

            // Close dropdown when clicking outside
        $(document).on('click', function(e) {
                if (!$searchContainer.is(e.target) && $searchContainer.has(e.target).length === 0) {
                    $searchDropdown.hide();
                }
            });

            // Prevent closing when clicking inside dropdown
            $searchDropdown.on('click', function(e) {
                e.stopPropagation();
            });
        }

        // Initialize service search
        initServiceSearch();
    }
})(jQuery);
