$(document).ready(function() {

    // static variable used for update records in main page
    var LAST_IMG = "";

    // Fix input element click problem
    $('.dropdown-menu').click(function(e) {
        e.stopPropagation();
    });

    // exchange Login & Recover forms
    $('.flipLink').click(function(e){
        // Flipping the forms
        $('#formContainer').toggleClass('flipped');
    });

    // Show compatible brand
    $(window).resize(function() {
        if ($(window).width() > 979) {
            $('.visible-desktop').css('display', 'block');
            $('.hidden-desktop').css('display', 'none');
        }
        else {
            $('.visible-desktop').css('display', 'none');
            $('.hidden-desktop').css('display', 'block');
        }
        $('#ScrollToTop').hide();
    });

    //Description with restrict chars
    $('textarea[maxlength]').keyup(function() {
        var max = parseInt($(this).attr('maxlength'));
        if($(this).val().length > max) {
            $(this).val($(this).val().substr(0, $(this).attr('maxlength')));
        }
        $(this).parent().find('.charsRemaining').html(' ' + (max - $(this).val().length) + ' characters remaining');
    });

    // resize comment box <!we have bug on this, when user press Enter!>
    $('textarea#comment-content').autosize();  

    $('textarea#comment-content').on("keyup input change", function () {
        $('#add-comment-btn').prop({ disabled: !$('textarea#comment-content').val() });
        $('#add-comment-btn').removeClass('disabled');
    });

    //Check to see if the window is top if not then display button
    $(window).scroll(function() {
        if ($(window).scrollTop() > 100) {
            $('#ScrollToTop:hidden').stop(true, true).fadeIn();
            $('#signUpLink:hidden').stop(true, true).fadeIn();
            if ($(window).width() > 979) {
                $('.brand img.visible-desktop').hide();
                $('.brand img.hidden-desktop').show();
            }
            if($(window).width() < 480) {
                $('#ScrollToTop').hide();
            }
        }
        else {
            $('#ScrollToTop').stop(true, true).fadeOut();
            $('#signUpLink').stop(true, true).fadeOut();
            if ($(window).width() > 979) {
                $('.brand img.hidden-desktop').hide();
                $('.brand img.visible-desktop').show();
            }
        }
    });
	
    //Click event to scroll to top
    $("#ScrollToTop").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    // when pop-up window want to close
    $('#pick').bind('hidden', function () {
        var src = PICKR['baseUrl'] + "resources/images/upload_picture.png";
        $('.thumbnail').attr('src', src);
    });

    // when pop-up window want to close
    $('#comment').bind('hidden', function () {
        var src = PICKR['baseUrl'] + "resources/images/upload_picture.png";
        $('.thumbnail').attr('src', src);
    });

    // when pop-up window want to close
    $('#upload-picture-form').bind('hidden', function () {
        var src = PICKR['baseUrl'] + "resources/images/upload_picture.png";
        $('.thumbnail').attr('src', src);
    });

    // show user actions
    $("#tiles li").hover(function() {
        var img_id = '#' + $(this).children().children().attr('id') + ' .tool-box';
        $(img_id).show();
        }, function() {
            var img_id = '#' + $(this).children().children().attr('id') + ' .tool-box';
            $(img_id).hide();
    });

    // Pick action
    $('#tiles').on('click', 'a.pick-btn', function() { // delegate pick-btn
        var image = '#' + $(this).parent().parent().attr('id') + ' img';
        var src = $(image).attr('src');
        $('.thumbnail#picked-pic').attr('src', src);

        // update last image clicked
        LAST_IMG = $(this).parent().parent().attr('id');
    });

    // Comment action
    $('a.comment-btn').click(function() {
        var image = '#' + $(this).parent().parent().attr('id') + ' img';
        var src = $(image).attr('src');
        $('.thumbnail#commented-pic').attr('src', src);

        // update last image clicked
        LAST_IMG = $(this).parent().parent().attr('id');

        // load comments
        var img = '#' + LAST_IMG;
        LoadComments(img);
    });

    // Comment action
    $('#tiles').on('click', 'a.comment-btn', function() { // delegate comment-btn
        var image = '#' + $(this).parent().parent().attr('id') + ' img';
        var src = $(image).attr('src');
        $('.thumbnail#commented-pic').attr('src', src);

        // update last image clicked
        LAST_IMG = $(this).parent().parent().attr('id');

        // load comments
        var img = '#' + LAST_IMG;
        LoadComments(img);
    });

    // like action
    $('#tiles').on('click', 'a.like-btn', function() { // delegate like-btn
        var image = '#' + $(this).parent().parent().attr('id');
        var form_data = {
            picture_id: image
        };
        $.ajax({
            url: PICKR['baseUrl'] + "home/like_picture",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, liked');
                    // update likes
                    var likes = Number($(image + ' span.record-like').html()) + 1;
                    $(image + ' span.record-like').html(likes);

                    // change icon to thumbs-down
                    $(image + ' i.icon-thumbs-up').addClass('icon-thumbs-down');
                    $(image + ' i.icon-thumbs-up').removeClass('icon-thumbs-up');

                    // remove like button & add dislike button
                    $(image + ' a.like-btn').addClass('dislike-btn');
                    $(image + ' a.like-btn').removeClass('like-btn');

                    // notification
                    //AddLikeNotification($(this).parent().parent().attr('id'));
                }
                else {
                    alert('Error, Can not like');
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        return false;
    });

    // unlike action
    $('#tiles').on('click', 'a.dislike-btn', function() { // delegate dislike-btn
        var image = '#' + $(this).parent().parent().attr('id');
        var form_data = {
            picture_id: image
        };
        $.ajax({
            url: PICKR['baseUrl'] + "home/dislike_picture",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, disliked');
                    // update likes
                    var likes = Number($(image + ' span.record-like').html()) - 1;
                    $(image + ' span.record-like').html(likes);

                    // change icon to thumbs-down
                    $(image + ' i.icon-thumbs-down').addClass('icon-thumbs-up');
                    $(image + ' i.icon-thumbs-down').removeClass('icon-thumbs-down');

                    // remove like button & add dislike button
                    $(image + ' a.dislike-btn').addClass('like-btn');
                    $(image + ' a.dislike-btn').removeClass('dislike-btn');
                }
                else {
                    alert('Error, Can not dislike');
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        return false;
    });

    // cover action
    $('.tool-box').on('click', 'a.cover-btn', function() { // delegate cover-btn
        var image = '#' + $(this).parent().parent().attr('id');
        var form_data = {
            picture_id: image,
            album_name: PICKR['uri_segment_3']
        };
        $.ajax({
            url: PICKR['baseUrl'] + "album/set_album_cover",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, coverd');
                    // update cover button
                    $(image + ' a.cover-btn').addClass('uncover-btn');
                    $(image + ' a.cover-btn').removeClass('cover-btn');

                    $(image + ' a.uncover-btn').html('<i class="icon-remove-circle"></i> Uncover');                    
                }
                else {
                    alert('Error, Can not cover');
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        return false;
    });

    // uncover action
    $('.tool-box').on('click', 'a.uncover-btn', function() { // delegate uncover-btn
        var image = '#' + $(this).parent().parent().attr('id');
        var form_data = {
            picture_id: 0,
            album_name: PICKR['uri_segment_3']
        };
        $.ajax({
            url: PICKR['baseUrl'] + "album/set_album_cover",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, uncoverd');
                    // update uncover button
                    $(image + ' a.uncover-btn').addClass('cover-btn');
                    $(image + ' a.uncover-btn').removeClass('uncover-btn');

                    $(image + ' a.cover-btn').html('<i class="icon-ok-circle"></i> Cover');                    
                }
                else {
                    alert('Error, Can not uncover');
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        return false;
    });

    // delete picture
    $('.delete-picture-btn').click(function() {
        var image = $(this).parent().parent().attr('id');
        var form_data = {
            picture_id: image,
            album_name: PICKR['uri_segment_3']
        };
        $.ajax({
            url: PICKR['baseUrl'] + "album/delete_picture",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Picture deleted');
                    window.location = PICKR['baseUrl'] + 'user/' + PICKR['uri_segment_2'] + '/' + PICKR['uri_segment_3'];
                }
                else {
                    alert('Error, Can not delete picture');
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        return false;
    });

    // delete album
    $('#delete-album-btn').click(function() {
        var form_data = {
            album_name: PICKR['uri_segment_3']
        };
        $.ajax({
            url: PICKR['baseUrl'] + "album/delete_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Album deleted');
                    window.location = PICKR['baseUrl'] + 'user/' + PICKR['uri_segment_2'];
                }
                else {
                    //alert('Error, Can not delete album');
                    $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
                }
            },
            error: function() {
                //alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
                $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
            }
        });
        return false;
    });


    // rename album
    $('#rename-album-btn').click(function() {
        var form_data = {
            old_album_name: $('#old_album_name').attr('placeholder').replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&'),
            new_album_name: $('#new_album_name').val().replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&')
        };
        $.ajax({
            url: PICKR['baseUrl'] + "album/rename_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Album renamed');
                    window.location = PICKR['baseUrl'] + 'user/' + PICKR['uri_segment_2'];
                }
                else {
                    //alert('Error, Can not rename picture');
                    $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        return false;
    });    

    // Create Album
    $('#create-album-btn').click(function() {
        $(this).button('loading');
        var form_data = {
            album_name: $('#album_name').val().replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&')
        };
        if(!$('#create-album-form').valid()) {
            $(this).button('reset');
            return false;
        }
        $.ajax({
            url: PICKR['baseUrl'] + "home/create_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Album created');
                    LoadAlbums(); // refresh album list
                    $('#album_name').attr('value', '');
                    SetCurrentAlbum(form_data['album_name']);
                }
                else {
                    //alert('Error, Can not create album');
                    $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
                }
            },
            error: function() {
                //alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
                $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
            }
        });
        $(this).button('reset');
        return false;
    });

    // Create Album V.2
    $('#new-album-btn').click(function() {
        $(this).button('loading');
        var form_data = {
            album_name: $('#album_name').val().replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&')
        };
        if(!$('#new-album-form').valid()) {
            $(this).button('reset');
            return false;
        }
        $.ajax({
            url: PICKR['baseUrl'] + "profile/new_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Album created');
                    window.location = PICKR['baseUrl'] + 'user/' + PICKR['uri_segment_2'];
                }
                else {
                    //alert('Error, Can not create album');
                    $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        $(this).button('reset');
        return false;
    });

    // Create Album V.3
    $('#upload-create-album-btn').click(function() {
        $(this).button('loading');
        var form_data = {
            album_name: $('#upload_album_name').val().replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&')
        };
        if(!$('#upload-create-album-form').valid()) {
            $(this).button('reset');
            return false;
        }
        $.ajax({
            url: PICKR['baseUrl'] + "home/create_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Album created');
                    LoadAlbums(); // refresh album list
                    $('#upload_album_name').attr('value', '');
                    SetCurrentAlbum_upload(form_data['album_name']);
                }
                else {
                    //alert('Error, Can not create album');
                    $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        $(this).button('reset');
        return false;
    });

    // pick
    $('#add-to-album-btn').click(function() {
        $(this).button('loading');
        var form_data = {
            picture_id: LAST_IMG,
            album_name: $('#current-album strong').html().replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&'),
            description: $('textarea#album-description').val()
        };
        if(!$('#pick-form').valid()) {
            $(this).button('reset');
            return false;
        }
        $.ajax({
            url: PICKR['baseUrl'] + "home/add_pic_to_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Picked');
                    //AddPickNotification();
                    $('#pick').modal('hide');
                }
                else {
                    //alert('Error, Can not pick');
                    $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        $(this).button('reset');
        return false;
    });

    // repick
    $('#repick-btn').click(function() {
        $(this).button('loading');
        var form_data = {
            picture_id: LAST_IMG,
            album_name: $('#current-album strong').html().replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&'),
            description: $('textarea#album-description').val()
        };
        if(!$('#repick-form').valid()) {
            $(this).button('reset');
            return false;
        }
        $.ajax({
            url: PICKR['baseUrl'] + "home/add_pic_to_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Picked');
                    //AddPickNotification();
                    window.location = PICKR['baseUrl'] + 'user/' + PICKR['uri_segment_2'] + '/' + PICKR['uri_segment_3'];
                }
                else {
                    //alert('Error, Can not pick');
                    $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        $(this).button('reset');
        return false;
    });


    // add comment
    $('#add-comment-btn').click(function() {
        $(this).button('loading');
        var image = '#' + LAST_IMG;
        var form_data = {
            picture_id: LAST_IMG,
            comment_content: $('textarea#comment-content').val()
        };
        if(!$('#comment-form').valid()) {
            $(this).button('reset');
            return false;
        }
        $.ajax({
            url: PICKR['baseUrl'] + "home/comment_on_picture",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Comment added');
                    // update comments
                    var comments = Number($(image + ' span.record-comment').html()) + 1;
                    $(image + ' span.record-comment').html(comments);
                    $('textarea#comment-content').val('');
                    $('#add-comment-btn').addClass('disabled');
                    $('#add-comment-btn').attr('disabled', 'disabled');
                    LoadComments(image); // load comments
                }
                else {
                    //alert('Error, Can not add comment');
                    $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
                }
            },
            error: function() {
                //alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
                $(".error-message").show().animate({opacity: 1.0}, 1000).fadeOut(3000);
            }
        });
        $(this).button('reset');
        return false;
    });

    $('.buttonContainer').on('click', '.follow-btn', function() { // delegate follow-btn
        $(this).button('loading');
        var form_data = {
            album_id: $(this).parent().parent().parent().attr('id')
        };
        $.ajax({
            url: PICKR['baseUrl'] + "profile/follow_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Followed');
                    /*
                    var handler = '#' + $(this).parent().parent().parent().attr('id') + ' button.follow-btn';
                    $(handler).html('<strong>Unfollow</strong>');
                    $(handler).attr('data-loading-text', 'Unfollowing...');
                    $(handler).addClass('unfollow-btn');
                    $(handler).removeClass('follow-btn');
                    */
                    window.location = PICKR['baseUrl'] + 'user/' + PICKR['uri_segment_2'];
                }
                else {
                    //alert('Error, Can not follow');
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        $(this).button('reset');
        return false;
    });

    $('.buttonContainer').on('click', '.unfollow-btn', function() { // delegate unfollow-btn
        $(this).button('loading');
        var form_data = {
            album_id: $(this).parent().parent().parent().attr('id')
        };
        $.ajax({
            url: PICKR['baseUrl'] + "profile/unfollow_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Unfollowed');
                    /*
                    var handler = '#' + $(this).parent().parent().parent().attr('id') + ' button.unfollow-btn';
                    $(handler).html('<strong>Follow</strong>');
                    $(handler).attr('data-loading-text', 'Following...');
                    $(handler).addClass('follow-btn');
                    $(handler).removeClass('unfollow-btn');
                    */
                    window.location = PICKR['baseUrl'] + 'user/' + PICKR['uri_segment_2'];
                }
                else {
                    //alert('Error, Can not Unfollow');
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        $(this).button('reset');
        return false;
    });

    $('.follow-all-btn').click(function() {
        $(this).button('loading');
        var form_data = {
            username: PICKR['uri_segment_2']
        };
        $.ajax({
            url: PICKR['baseUrl'] + "profile/follow_person",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Unfollowed');
                    window.location = PICKR['baseUrl'] + 'user/' + PICKR['uri_segment_2'];
                }
                else {
                    //alert('Error, Can not Unfollow');
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        $(this).button('reset');
        return false;
    });

    $('.unfollow-all-btn').click(function() {
        $(this).button('loading');
        var form_data = {
            username: PICKR['uri_segment_2']
        };
        $.ajax({
            url: PICKR['baseUrl'] + "profile/unfollow_person",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success, Unfollowed');
                    window.location = PICKR['baseUrl'] + 'user/' + PICKR['uri_segment_2'];
                }
                else {
                    //alert('Error, Can not Unfollow');
                }
            },
            error: function() {
                alert('Ajax Error');
                //window.location = PICKR['baseUrl'];
            }
        });
        $(this).button('reset');
        return false;
    });

    // load notifications
    $('#dropdown-notification').click(function() {
        $('#dropdown-notification-content').html('');
        $.ajax({
            url: PICKR['baseUrl'] + "home/load_notifications",
            type: 'POST',
            dataType: 'JSON',
            success: function(result) {
                $('#dropdown-notification-content').html(result);
            },
            error: function() {
                alert('Ajax Error');
            }
        });
    });
});



function LoadComments(pictureId) {
    $('.comments').html('');
    var form_data = {
        picture_id: pictureId
    };
    $.ajax({
        url: PICKR['baseUrl'] + "home/load_comments",
        type: 'POST',
        dataType: 'JSON',
        data: form_data,
        success: function(result) {
            if(result) {
                //alert('Success, Comments loaded');
                $('.comments').html(result);
            }
            else {
                //alert('Error, No comment exists for loading');
            }
        },
        error: function() {
            alert('Ajax Error');
            //window.location = PICKR['baseUrl'];
        }
    });
    return false;
}

function LoadAlbums() {
    $('.albums').html('');
    $.ajax({
        url: PICKR['baseUrl'] + "home/load_albums",
        type: 'POST',
        dataType: 'JSON',
        success: function(result) {
            if(result) {
                //alert('Success, Albums loaded');
                $('.albums').html(result);
            }
            else {
                //alert('Error, No album exists for loading');
            }
        },
        error: function() {
            alert('Ajax Error');
            //window.location = PICKR['baseUrl'];
        }
    });
    return false;
}

function ShowActions(this_obj) {
    var img_id = '#' + $(this_obj).children().children().attr('id') + ' .tool-box';
    $(img_id).show();
}

function HideActions(this_obj) {
    var img_id = '#' + $(this_obj).children().children().attr('id') + ' .tool-box';
    $(img_id).hide();
}

function ShowDescriptionMessage() {
    $('.charsRemaining').css('display', 'block');
}

function HideDescriptionMessage() {
    $('.charsRemaining').css('display', 'none');
}

function SetCurrentAlbum(current_value) {
    var value = '<strong style="float: left;">' + current_value + '</strong> <span class="caret" style="float: right;"></span>';
    $('#current-album').html(value);
    $('#add-to-album-btn').removeClass('disabled');
    $('#add-to-album-btn').removeAttr('disabled');

    $('[data-toggle="dropdown"]').parent().removeClass('open');
}

function SetCurrentAlbum_repick(current_value) {
    var value = '<strong style="float: left;">' + current_value + '</strong> <span class="caret" style="float: right;"></span>';
    $('#current-album').html(value);
    $('#repick-btn').removeClass('disabled');
    $('#repick-btn').removeAttr('disabled');

    $('[data-toggle="dropdown"]').parent().removeClass('open');
}

function SetCurrentAlbum_upload(current_value) {
    var value = '<strong style="float: left;">' + current_value + '</strong> <span class="caret" style="float: right;"></span>';
    $('#upload-current-album').html(value);
    $('#upload-btn').removeClass('disabled');
    $('#upload-btn').removeAttr('disabled');

    $('[data-toggle="dropdown"]').parent().removeClass('open');
}

// notification
function AddPickNotification(pictureId) {
    var form_data = {
        picture_id: pictureId
    };
    $.ajax({
        url: PICKR['baseUrl'] + "home/add_pick_notification",
        type: 'POST',
        dataType: 'JSON',
        data: form_data,
        success: function(result) {
            // alert('Pick Notification Added.');
        },
        error: function() {
            alert('Ajax Error');
        }
    });
}

function AddLikeNotification(pictureId) {
    var form_data = {
        picture_id: pictureId
    };
    $.ajax({
        url: PICKR['baseUrl'] + "home/add_like_notification",
        type: 'POST',
        dataType: 'JSON',
        data: form_data,
        success: function(result) {
            // alert('Like Notification Added.');
        },
        error: function() {
            alert('Ajax Error');
        }
    });
}