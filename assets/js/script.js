(function() {
    'use strict';
    
    // Location selection
    let selectedLocation = '';
    let locationData = [];
    
    // Load locations via AJAX
    function loadLocationsAjax() {
        const locationSelect = document.getElementById('locationSelect');
        if (!locationSelect) return;
        
        // Show loading state
        locationSelect.disabled = true;
        locationSelect.innerHTML = '<option value="">جاري التحميل...</option>';
        
        // AJAX request to load locations
        const xhr = new XMLHttpRequest();
        xhr.open('GET', cscAjax.ajaxurl || '/wp-admin/admin-ajax.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                locationSelect.disabled = false;
                
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.success && response.data && response.data.locations) {
                            locationData = response.data.locations;
                            populateLocationSelect(locationSelect, locationData);
                            
                            // Load saved location after populating
                            const savedLocation = localStorage.getItem('csc_selected_location');
                            if (savedLocation) {
                                locationSelect.value = savedLocation;
                                selectedLocation = savedLocation;
                            }
                        } else {
                            // Fallback: use default locations if AJAX fails
                            console.warn('AJAX failed, using default locations');
                            loadDefaultLocations(locationSelect);
                        }
                    } catch (e) {
                        console.error('Error parsing location data:', e);
                        loadDefaultLocations(locationSelect);
                    }
                } else {
                    console.error('AJAX request failed:', xhr.status);
                    loadDefaultLocations(locationSelect);
                }
            }
        };
        
        // Send request (POST method for better compatibility)
        const params = new URLSearchParams();
        params.append('action', 'csc_get_locations');
        params.append('nonce', cscAjax.nonce || '');
        xhr.open('POST', cscAjax.ajaxurl || '/wp-admin/admin-ajax.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(params.toString());
    }
    
    // Populate location select with data
    function populateLocationSelect(select, locations) {
        select.innerHTML = '<option value="">-- اختر الموقع --</option>';
        
        // Group locations by region
        const regions = {};
        locations.forEach(location => {
            const region = location.region || 'أخرى';
            if (!regions[region]) {
                regions[region] = [];
            }
            regions[region].push(location);
        });
        
        // Create optgroups
        Object.keys(regions).sort().forEach(region => {
            const optgroup = document.createElement('optgroup');
            optgroup.label = region;
            
            regions[region].forEach(location => {
                const option = document.createElement('option');
                option.value = location.name;
                option.textContent = location.name;
                optgroup.appendChild(option);
            });
            
            select.appendChild(optgroup);
        });
    }
    
    // Fallback: Load default locations if AJAX fails
    function loadDefaultLocations(select) {
        const defaultLocations = [
            {region: 'المنطقة الشرقية', name: 'الدمام'},
            {region: 'المنطقة الشرقية', name: 'الخبر'},
            {region: 'المنطقة الشرقية', name: 'الظهران'},
            {region: 'منطقة الرياض', name: 'الرياض'},
            {region: 'منطقة مكة المكرمة', name: 'مكة المكرمة'},
            {region: 'منطقة مكة المكرمة', name: 'جدة'},
            {region: 'منطقة المدينة المنورة', name: 'المدينة المنورة'},
            {region: 'منطقة القصيم', name: 'بريدة'},
            {region: 'منطقة عسير', name: 'أبها'},
            {region: 'منطقة تبوك', name: 'تبوك'},
            {region: 'منطقة حائل', name: 'حائل'}
        ];
        
        populateLocationSelect(select, defaultLocations);
        
        // Load saved location
        const savedLocation = localStorage.getItem('csc_selected_location');
        if (savedLocation) {
            select.value = savedLocation;
            selectedLocation = savedLocation;
        }
    }
    
    // Initialize location selector
    function initLocationSelector() {
        const locationSelect = document.getElementById('locationSelect');
        if (locationSelect) {
            // Try to load via AJAX first (for WordPress)
            if (typeof cscAjax !== 'undefined' && cscAjax.ajaxurl) {
                loadLocationsAjax();
            } else {
                // Fallback to default locations (for local testing)
                loadDefaultLocations(locationSelect);
            }
            
            // Handle location change
            locationSelect.addEventListener('change', function(e) {
                selectedLocation = e.target.value;
                localStorage.setItem('csc_selected_location', selectedLocation);
                
                // Update URL when location changes
                if (selectedLocation) {
                    console.log('Location selected:', selectedLocation);
                }
            });
        }
    }
    
    // Wait for DOM to be fully ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initLocationSelector();
            initServices();
        });
    } else {
        // DOM is already ready, but wait a bit for shortcode content
        initLocationSelector();
        setTimeout(initServices, 100);
    }
    
    function initServices() {
        // Check if service container exists on the page
        const carousel = document.querySelector('.csc-service-carousel');
        if (!carousel) {
            console.log('Service container not found on page');
            return;
        }
        
        // Get elements
        const secondaryServicesContainer = document.getElementById("secondaryServices");
        const goButton = document.getElementById("goButton");

        // Check if required elements exist
        if (!secondaryServicesContainer) {
            console.error("Secondary services container not found");
            return;
        }
        
        if (!goButton) {
            console.error("Go button not found");
            return;
        }
        
        // Check if cscData is available
        if (typeof cscData === 'undefined' || !cscData || !cscData.secondaryServices) {
            console.error("cscData is not defined. Make sure the plugin is properly configured.");
            return;
        }

        // Track selected secondary services (use Set for uniqueness)
        let selectedSecondaryServices = new Set();

        // Handle Go button clicks
        goButton.addEventListener('click', onGoButtonClick);

        function onGoButtonClick(e) {
            e.preventDefault();
            e.stopPropagation();

            if (selectedSecondaryServices.size === 0) {
                alert("يرجى اختيار خدمة فرعية أولاً");
                return;
            }

            const selectedMainService = carousel.querySelector(".csc-service-box.marked");
            if (!selectedMainService) {
                alert("يرجى اختيار خدمة رئيسية أولاً");
                return;
            }

            const selectedCategory = selectedMainService.getAttribute("data-category");
            const baseUrl = selectedMainService.getAttribute("data-url");

            if (!selectedCategory || !baseUrl) {
                alert("تعذر تحديد الخدمة. حاول مرة أخرى.");
                return;
            }

            updateURL(baseUrl, selectedCategory);
        }

        // Function to update URL
        function updateURL(baseUrl, category) {
            // Validate inputs
            if (!baseUrl || !category) {
                console.error("Missing baseUrl or category");
                return;
            }
            
            // Create a properly formatted URL
            try {
                const origin = window.location.origin || (window.location.protocol + '//' + window.location.host);
                const safeBase = String(baseUrl).replace(/^\/+|\/+$/g, '');
                const url = new URL(`${origin}/directory-category/${safeBase}/`);

                // Add selected secondary services as query parameters based on category
                if (category === "البناء الذاتي والتشطيب") {
                    selectedSecondaryServices.forEach(service => {
                        url.searchParams.append("filter_field_constarcion[]", service);
                    });
                    url.searchParams.append("drts-search", "1");
                    url.searchParams.append("search_keyword[text]", "البناء الذاتي والتشطيب");
                    url.searchParams.append("search_keyword[id]", "83");
                    url.searchParams.append("search_keyword[taxonomy]", "directory_category");
                    url.searchParams.append("filter_location_address[radius]", "84");
                } else if (category === "صيانة المنازل الدورية") {
                    selectedSecondaryServices.forEach(service => {
                        url.searchParams.append("filter_field_maintenance[]", service);
                    });
                    url.searchParams.append("drts-search", "1");
                    url.searchParams.append("search_keyword[text]", "صيانة المنازل الدورية");
                    url.searchParams.append("search_keyword[id]", "85");
                    url.searchParams.append("search_keyword[taxonomy]", "directory_category");
                    url.searchParams.append("filter_location_address[radius]", "84");
                } else if (category === "الموردين والمواد") {
                    selectedSecondaryServices.forEach(service => {
                        url.searchParams.append("filter_field_sourcing[]", service);
                    });
                    url.searchParams.append("drts-search", "1");
                    url.searchParams.append("search_keyword[text]", "الموردين والمواد");
                    url.searchParams.append("search_keyword[id]", "37");
                    url.searchParams.append("search_keyword[taxonomy]", "directory_category");
                    url.searchParams.append("filter_location_address[radius]", "84");
                } else if (category === "المعدات والخدمات المساندة") {
                    selectedSecondaryServices.forEach(service => {
                        url.searchParams.append("filter_field_hiring[]", service);
                    });
                    url.searchParams.append("drts-search", "1");
                    url.searchParams.append("search_keyword[text]", "المعدات والخدمات المساندة");
                    url.searchParams.append("search_keyword[id]", "87");
                    url.searchParams.append("search_keyword[taxonomy]", "directory_category");
                    url.searchParams.append("filter_location_address[radius]", "84");
                } else {
                    // Default case for categories without defined subcategories
                    url.searchParams.append("drts-search", "1");
                    url.searchParams.append("search_keyword[text]", category);
                    url.searchParams.append("search_keyword[taxonomy]", "directory_category");
                    url.searchParams.append("filter_location_address[radius]", "84");
                }

                // Add additional fixed query parameters
                url.searchParams.append("filter", "1");
                url.searchParams.append("sort", "post_published");

                // Add location to URL if selected
                if (selectedLocation) {
                    url.searchParams.append("location", selectedLocation);
                }

                // Redirect to the final URL
                console.log("Redirecting to:", url.toString());
                console.log("Selected Location:", selectedLocation || 'None');
                window.location.href = url.toString();
            } catch (error) {
                console.error("Error building URL:", error);
                alert("حدث خطأ في بناء الرابط. يرجى المحاولة مرة أخرى.");
            }
        }
        
        // Use event delegation for main service boxes
        carousel.addEventListener("click", function(e) {
            // Check if click is on a main service box
            const serviceBox = e.target.closest('.csc-main-categories .csc-service-box');
            if (serviceBox) {
                e.preventDefault();
                const category = serviceBox.getAttribute("data-category");
                const url = serviceBox.getAttribute("data-url");

                // Deselect all main categories
                carousel.querySelectorAll(".csc-main-categories .csc-service-box").forEach(b => b.classList.remove("marked"));

                // Select the clicked main category
                if (category) {
                    serviceBox.classList.add("marked");
                    
                    // Check if this category has secondary services
                    if (cscData.secondaryServices[category]) {
                        // Display secondary services container
                        secondaryServicesContainer.style.display = "flex";
                        // Reset selected secondary services for the new category
                        selectedSecondaryServices = new Set();
                        goButton.style.display = "none";
                        secondaryServicesContainer.innerHTML = "";

                        // Display secondary services
                        cscData.secondaryServices[category].forEach(service => {
                            const serviceBoxEl = document.createElement("a");
                            serviceBoxEl.className = "csc-service-box";
                            serviceBoxEl.href = "#";
                            serviceBoxEl.innerHTML = `
                                <i class="${service.icon}"></i>
                                <h4>${service.title}</h4>
                            `;

                            // Add click event to mark/unmark the service
                            serviceBoxEl.addEventListener("click", (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                serviceBoxEl.classList.toggle("marked");

                                // Update selected secondary services
                                if (serviceBoxEl.classList.contains("marked")) {
                                    selectedSecondaryServices.add(service.title);
                                } else {
                                    selectedSecondaryServices.delete(service.title);
                                }

                                // Show/hide the Go button
                                if (selectedSecondaryServices.size > 0) {
                                    goButton.style.display = "block";
                                } else {
                                    goButton.style.display = "none";
                                }
                            });

                            secondaryServicesContainer.appendChild(serviceBoxEl);
                        });
                    } else {
                        // For categories without secondary services, navigate directly
                        selectedSecondaryServices = new Set();
                        secondaryServicesContainer.style.display = "none";
                        goButton.style.display = "none";
                        updateURL(url, category);
                    }
                }
            } else if (e.target.closest('#goButton') == null) {
                // Clicked outside of service boxes (e.g., deselect area)
                selectedSecondaryServices = new Set();
                secondaryServicesContainer.style.display = "none";
                goButton.style.display = "none";
                carousel.querySelectorAll(".csc-main-categories .csc-service-box").forEach(b => b.classList.remove("marked"));
            }
        });
    }
})();
