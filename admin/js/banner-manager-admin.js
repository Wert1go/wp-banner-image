jQuery(document).ready(function($) {
    $('#upload_image_button').click(function(e) {
        e.preventDefault();
        
        var image = wp.media({
            title: 'Upload Banner Image',
            multiple: false
        }).open()
        .on('select', function(e) {
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#banner_manager_image').val(image_url);
        });
    });
}); 