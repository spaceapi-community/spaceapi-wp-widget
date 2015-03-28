jQuery(function ($) {
    /* You can safely use $ in this code block to reference jQuery */
    $.getJSON(php_vars.url, function(data) {
        if (data.state.open) {
            var status_value = 'Open';
        } else {
            var status_value = 'Closed';
        }
        if (data.state.message) {
            $('.opening_status_value').text(status_value + ':');
            $('.opening_status_message').text(data.state.message);
        } else {
            $('.opening_status_value').text(status_value);
        }
    });
});
