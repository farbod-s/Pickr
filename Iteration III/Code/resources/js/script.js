/*$(window).load(function() {*/
$(document).ready(function() {

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

    // Pick action
    $("a[data-toggle=modal]").click(function() {
        var image = '#' + $(this).parent().parent().attr('id') + ' img';
        var src = $(image).attr('src');
        $('.thumbnail').attr('src', src);
    });

    // when pop-up window want to close
    $('#pick').bind('hidden', function () {
        var src = "http://localhost/www/codeigniter/resources/images/220x200.gif";
        $('.thumbnail').attr('src', src);
    });

    // Create Album
    $('#create-album-btn').click(function() {
        var form_data = {
            album_name: $('#album_name').val()
        };
        if(!$('#create-album-form').valid())
            return false;
        $.ajax({
            url: "http://localhost/www/codeigniter/index.php/home/create_album",
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(result) {
                if(result) {
                    //alert('Success');
                    var item = $('<li><a href="#" onClick="SetCurrentAlbum(this.innerHTML)">' + $('#album_name').val() + '</a></li>');
                    $("#album_list").prepend(item);
                    $('#album_name').attr('value', '');
                    //window.location = "index.php/setting";
                }
                else {
                    alert('Error'); // TODO
                }
            },
            error: function() {
                alert('Fatal Error');
                //window.location = "index.php/setting";
            }
        });
        return false;
    });
});

function ShowActions(id) {
    var img_id = '#' + id + ' .tool-box';
    $(img_id).css('display', 'block');
}

function HideActions(id) {
    var img_id = '#' + id + ' .tool-box';
    $(img_id).css('display', 'none');
}

function Like(id) {
    alert("Like " + id);
}

function Comment(id) {
    alert("Comment " + id);
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
        var img = $(div).find("img").get(0);
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
        var img = $(div).find("img").get(0);
        StretchImage(div, img);
    });
}
