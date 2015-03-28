jQuery(function ($) {
    // Download the JSON data from the SpaceAPI endpoint
    $.getJSON(php_vars.url, function(data) {

        // Show status
        if (data.state.open) {
            var status_value = 'Open';
        } else {
            var status_value = 'Closed';
        }

        // If a message is provided, append it to the status
        if (data.state.message) {
            $('.opening_status_value').text(status_value + ':');
            $('.opening_status_message').text(data.state.message);
        } else {
            $('.opening_status_value').text(status_value);
        }

    });
});
