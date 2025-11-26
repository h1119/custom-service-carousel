jQuery(document).ready(function($) {
    // Initialize color pickers
    $('.color-picker').wpColorPicker();

    // Live preview functionality
    function updatePreview() {
        var options = {
            enableSearch: $('#enable_search').is(':checked'),
            carouselWidth: $('#carousel_width').val(),
            primaryColor: $('#primary_color').val(),
            secondaryColor: $('#secondary_color').val(),
            boxMinWidth: $('#box_min_width').val(),
            boxMaxWidth: $('#box_max_width').val()
        };

        // Update preview styles
        $('.live-preview .service-carousel').css({
            'max-width': options.carouselWidth + 'px'
        });

        $('.live-preview .service-box').css({
            'min-width': options.boxMinWidth + 'px',
            'max-width': options.boxMaxWidth + 'px'
        });

        $('.live-preview .service-box i').css('color', options.primaryColor);
        $('.live-preview .service-box:hover').css('box-shadow', '0 5px 15px ' + options.primaryColor + '33');

        // Toggle search bar
        if (options.enableSearch) {
            $('.live-preview .search-bar').show();
        } else {
            $('.live-preview .search-bar').hide();
        }
    }

    // Update preview on input change
    $('input').on('input change', function() {
        updatePreview();
    });

    // Device preview functionality
    $('.preview-device').click(function() {
        $('.preview-device').removeClass('active');
        $(this).addClass('active');

        var device = $(this).data('device');
        var previewContainer = $('.preview-container');

        switch(device) {
            case 'desktop':
                previewContainer.css('width', '100%');
                break;
            case 'tablet':
                previewContainer.css('width', '768px');
                break;
            case 'mobile':
                previewContainer.css('width', '375px');
                break;
        }
    });

    // Initialize preview
    updatePreview();

    // Add sample content for preview
    if ($('.live-preview').length && !$('.live-preview .service-box').length) {
        var sampleContent = `
            <div class="service-carousel">
                <div class="service-box">
                    <i class="fas fa-home"></i>
                    <h4>Home Services</h4>
                </div>
                <div class="service-box">
                    <i class="fas fa-car"></i>
                    <h4>Transportation</h4>
                </div>
                <div class="service-box">
                    <i class="fas fa-utensils"></i>
                    <h4>Food & Dining</h4>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Search services...">
                    <button type="button">Search</button>
                </div>
            </div>
        `;
        $('.live-preview').html(sampleContent);
    }
}); 