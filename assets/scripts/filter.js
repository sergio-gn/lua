jQuery(function($) {
    $('#filter').on('submit', function(e) {
        e.preventDefault();

        var country = [];
        $('input[name="country[]"]:checked').each(function() {
            // Exclude the "All Countries" checkbox from the selected countries
            if (this.value !== 'all') {
                country.push(this.value);
            }
        });

        // Check if no checkboxes are selected
        if (country.length === 0) {
            alert('Please select at least one country before proceeding.');
            return; // Stop execution
        }

        // Disable the button
        $('#filter-button').prop('disabled', true);

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'filter_posts',
                country: country
            },
            success: function(response) {
                $('#hoomans_no-query').remove();
                $('#response').html(response);
                $('.pagination').remove(); // Remove pagination when filtering results
            },
            complete: function() {
                // Re-enable the button after AJAX request is complete
                $('#filter-button').prop('disabled', false);
            }
        });
    });

    // Button to select all countries
    $('#select-all-button').on('click', function() {
        $('input[name="country[]"]').prop('checked', true);
    });

    // Uncheck the "All Countries" checkbox when any other country checkbox is selected
    $('input[name="country[]"]').not('[value="all"]').on('change', function() {
        if (this.checked) {
            $('input[name="country[]"][value="all"]').prop('checked', false);
        }
    });
});