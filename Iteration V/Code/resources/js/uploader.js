$(document).ready(function() {
    // upload
    $('#upload_file').submit(function(e) {
        e.preventDefault();
        $('#upload-btn').button('loading');
        $("#loading").ajaxStart(function() {
            $(this).show();
        }).ajaxComplete(function() {
            $(this).hide();
        });
        $.ajaxFileUpload({
            url: PICKR['baseUrl'] + 'upload/upload_file',
            secureuri: false,
            fileElementId: 'userfile',
            type: 'POST',
            dataType: 'JSON',
            data: {
                album_name: $('#upload-current-album strong').html().replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&'),
                description: $('textarea#upload-album-description').val()
            },
            success: function (data, status) {
                var myObject = JSON.parse(data); // pars json array
                if(status == "success" && myObject.status != "error") {
                    // show thumbnail
                    $('#uploaded-pic').attr('onLoad', 'OnImageLoad(event)');
                    $('#uploaded-pic').attr('src', myObject.picture_path);
                    $("#success-upload-msg").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
                }
                else {
                    $("#success-upload-msg").hide();
                }
            },
            error: function (s, xml, status) {;
                alert('Ajax Error');
            }
        });
        $('#upload-btn').button('reset');
        return false;
    });
});