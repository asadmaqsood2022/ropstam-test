jQuery(document).ready(function($) {
    $.ajax({
        url: ajaxurl,
        type: 'GET',
        dataType: 'json',
        data: {
            action: 'get_architecture_projects'
        },
        success: function(response) {
            if (response.success && response.data) {
                console.log(response.data); 
            } else {
                console.log('Error fetching projects.');
            }
        },
        error: function(errorThrown) {
            console.log('Ajax request error: ' + errorThrown);
        }
    });
});
