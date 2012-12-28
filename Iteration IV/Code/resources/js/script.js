$(document).ready(function() {

    // used in update comment record in main page
    var LAST_IMG = "";

    // Fix input element click problem
    $('.dropdown-menu').click(function(e) {
        e.stopPropagation();
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
    });

    // fix lazy images
    $("img.lazy").bind("load", function (evt) {
        var img;
        if (evt && evt.currentTarget)
            img = evt.currentTarget;
        else
            img = window.event.srcElement;

        // what's the size of this image and it's parent
        var w = $(img).width();
        var h = $(img).height();
        var tw = $(img).parent().width();
        var th = $(img).parent().height();

        // compute the new size and offsets
        var result = ScaleImage(w, h, tw, th, false);

        // adjust the image coordinates and size
        img.width = result.width;
        img.height = result.height;
        $(img).css("left", result.targetleft);
        $(img).css("top", result.targettop);
    });

    //Description with restrict chars
    $('textarea[maxlength]').keyup(function() {
        var max = parseInt($(this).attr('maxlength'));
        if($(this).val().length > max) {
            $(this).val($(this).val().substr(0, $(this).attr('maxlength')));
        }
        $(this).parent().find('.charsRemaining').html(' ' + (max - $(this).val().length) + ' characters remaining');
    });

    //Check to see if the window is top if not then display button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#ScrollToTop:hidden').stop(true, true).fadeIn();
        }
        else {
            $('#ScrollToTop').stop(true, true).fadeOut();
        }
    });

    //Click event to scroll to top
    $("#ScrollToTop").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    // show user actions
    $(".article").hover(function() {
        var img_id = '#' + $(this).children().children().children().attr('id') + ' .tool-box';
        $(img_id).css('display', 'block');
        }, function() {
            var img_id = '#' + $(this).children().children().children().attr('id') + ' .tool-box';
            $(img_id).css('display', 'none');
    });

    // Pick action
    $("a.pick-btn[data-toggle=modal]").click(function() {
        var image = '#' + $(this).parent().parent().attr('id') + ' img';
        var src = $(image).attr('src');
        $('.thumbnail').attr('src', src);
    });

    // resize comment box <!we have bug on this, when user press Enter!>
    $('textarea#comment-content').autosize();  

    $('textarea#comment-content').on("keyup input change", function () {
        $('#add-comment-btn').prop({ disabled: !$('textarea#comment-content').val() });
        $('#add-comment-btn').removeClass('disabled');
        //$('#add-comment-btn').removeAttr('disabled');
    });

    // Comment action
    $("a.comment-btn[data-toggle=modal]").click(function() {
        var image = '#' + $(this).parent().parent().attr('id') + ' img';
        var src = $(image).attr('src');
        $('.thumbnail').attr('src', src);

        // update last image clicked
        LAST_IMG = '#' + $(this).parent().parent().attr('id');
    });

    // like action
    $('.tool-box').on('click', 'a.like-btn', function() { // delegate like-btn
        var image = '#' + $(this).parent().parent().attr('id');
        var form_data = {
            picture_path: $(image + ' img').attr('src')
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
                    // AddLikeNotification($(this).parent().parent().attr('id'));
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

    // dislike action
    $('.tool-box').on('click', 'a.dislike-btn', function() { // delegate dislike-btn
        var image = '#' + $(this).parent().parent().attr('id');
        var form_data = {
            picture_path: $(image + ' img').attr('src')
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

    // delete picture
    $('.delete-picture-btn').click(function() {
        var image = '#' + $(this).parent().parent().attr('id');
        var form_data = {
            picture_path: $(image + ' img').attr('src'),
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

    // when pop-up window want to close
    $('#pick').bind('hidden', function () {
        var src = PICKR['baseUrl'] + "resources/images/220x200.gif";
        $('.thumbnail').attr('src', src);
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

    // pick
    $('#add-to-album-btn').click(function() {
        $(this).button('loading');
        var form_data = {
            picture_path: $('#picked-pic').attr('src'),
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

    // add comment
    $('#add-comment-btn').click(function() {
        $(this).button('loading');
        var form_data = {
            picture_path: $('#commented-pic').attr('src'),
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
                    var comments = Number($(LAST_IMG + ' span.record-comment').html()) + 1;
                    $(LAST_IMG + ' span.record-comment').html(comments);
                    $('textarea#comment-content').val('');
                    LoadComments(); // load comments
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

    // load comment
    $('.comment-btn').click(function() {
        $('.comments').html('');
        $('#comment').modal('show');
        var form_data = {
            picture_path: $('#commented-pic').attr('src')
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



function LoadComments() {
    $('.comments').html('');
    var form_data = {
        picture_path: $('#commented-pic').attr('src')
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



/*** Fix images ***/

function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {
    var result = { width: 0, height: 0, fScaleToTargetWidth: true };

    if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {
        return result;
    }

    // scale to the target width
    var scaleX1 = targetwidth;
    var scaleY1 = (srcheight * targetwidth) / srcwidth;

    // scale to the target height
    var scaleX2 = (srcwidth * targetheight) / srcheight;
    var scaleY2 = targetheight;

    // now figure out which one we should use
    var fScaleOnWidth = (scaleX2 > targetwidth);
    if (fScaleOnWidth) {
        fScaleOnWidth = fLetterBox;
    }
    else {
       fScaleOnWidth = !fLetterBox;
    }

    if (fScaleOnWidth) {
        result.width = Math.floor(scaleX1);
        result.height = Math.floor(scaleY1);
        result.fScaleToTargetWidth = true;
    }
    else {
        result.width = Math.floor(scaleX2);
        result.height = Math.floor(scaleY2);
        result.fScaleToTargetWidth = false;
    }
    result.targetleft = Math.floor((targetwidth - result.width) / 2);
    result.targettop = Math.floor((targetheight - result.height) / 2);

    return result;
}

function OnImageLoad(evt) {
    var img;
    if (evt && evt.currentTarget)
        img = evt.currentTarget;
    else
        img = window.event.srcElement;

    // what's the size of this image and it's parent
    var w = $(img).width();
    var h = $(img).height();
    var tw = $(img).parent().width();
    var th = $(img).parent().height();

    // compute the new size and offsets
    var result = ScaleImage(w, h, tw, th, false);

    // adjust the image coordinates and size
    img.width = result.width;
    img.height = result.height;
    $(img).css("left", result.targetleft);
    $(img).css("top", result.targettop);
}

function RememberOriginalSize(img) {
    if (!img.originalsize) {
        img.originalsize = {width : img.width, height : img.height};
    }
}

function FixImage(fLetterBox, div, img) {
    RememberOriginalSize(img);

    var targetwidth = $(div).width();
    var targetheight = $(div).height();
    var srcwidth = img.originalsize.width;
    var srcheight = img.originalsize.height;
    var result = ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox);

    img.width = result.width;
    img.height = result.height;
    $(img).css("left", result.targetleft);
    $(img).css("top", result.targettop);
}

function FixImages(fLetterBox) {
    $(".article").each(function (index, div) {
        var img = $(div).find("img.lazy").get(0);
        FixImage(fLetterBox, div, img);
    });
}

function StretchImage(div, img) {
    RememberOriginalSize(img);

    var targetwidth = $(div).width();
    var targetheight = $(div).height();

    img.width = targetwidth;
    img.height = targetheight;
    $(img).css("left", 0);
    $(img).css("top", 0);
}

function StretchImages() {
    $(".article").each(function (index, div) {
        var img = $(div).find("img.lazy").get(0);
        StretchImage(div, img);
    });
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