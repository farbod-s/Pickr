/*$(document).ready(function() {*/
$(window).load(function() {

    // Some Variables
    var noBoxes = $('#holder .box');
    var randNumber, prev;
    var i = 0;
     
    //Run a while loop to go through all the boxes
    while(i < noBoxes.length) {
         
        // ensure the random number is different every time
        do {
            randNumber = Math.floor(Math.random() * (6 - 2) + 2); // the random number
        } while(randNumber === prev);
        prev = randNumber;
         
        // If i is 0, it's the first set of boxes, so wrap the first 5 in a wrapper (the header)
        if(i == 0) {
            noBoxes.slice(0, 5).wrapAll("<div class='wrapper'></div>");
            i+=5;
        }
        // Otherwise..
        else {
            // If i is 5 it's the second set of boxes, so ensure that the random number isn't 5.
            if(i == 5) {
                newRand = Math.floor(Math.random() * (5 - 2) + 2); 
                noBoxes.slice(i, i+newRand).wrapAll("<div class='wrapper'></div>");
                i+=newRand;
            }
            // Then just run the loop normally
            else {
                noBoxes.slice(i, i+randNumber).wrapAll("<div class='wrapper'></div>");
                i+=randNumber;
            }
             
        }
    }
     
    // Since the wrappers have been made, run this function for each
    $('.wrapper').each(function() {
     
        // Get the number of children in this wrapper
        var noChildren = $(this).children('.box').length;
         
        // An array of the classes we're going to use
        var cssClass = [
            'single', // 1 IMAGE PER WRAPPER
            'left-big', 'left-small', // 2 IMAGES PER WRAPPER
            'small-middle', 'big-middle', // 3 IMAGES PER WRAPPER
            'middle-two-rows', 'right-two-rows', // 4 IMAGES PER WRAPPER
            'four-block' // 4 IMAGES PER WRAPPER
        ];
         
        // If there is only 1 child then add this class
        if(noChildren == 1) {
         
            $(this).addClass(cssClass[0]);
             
        }
        else if(noChildren == 2) {
         
            // 2 per wrapper, so get a number between 1 and 2, and add this class to this wrapper
            var rand = Math.floor(Math.random() * (3 - 1) + 1);
            $(this).addClass(cssClass[rand]);
             
        }
        else if(noChildren == 3) {
         
            // 3 per wrapper, same as before
            var rand = Math.floor(Math.random() * (5 - 3) + 3);
            $(this).addClass(cssClass[rand]);
             
        }
        else if(noChildren == 4) {
         
            // 4 per wrapper, same as before
            var rand = Math.floor(Math.random() * (7 - 5) + 5);
            $(this).addClass(cssClass[rand]);
             
            // if the CSS class is this particular class then wrap the divs accordingly.
            // This is simply for layout reasons.
            if(cssClass[rand] == 'middle-two-rows') {
                $(this).children().slice(1, 3).wrapAll("<div class='middle'></div>");
            } else {
                $(this).children().slice(2, 5).wrapAll("<div class='middle'></div>");
            }
             
        }
        else if(noChildren == 5) {
            // 5 per wrapper, there is only one type of layout, so no random classes
            $(this).addClass(cssClass[7]);
            // Wrap the last 4 div's so we can lay them out appropriately.
            $(this).children().slice(1, 5).wrapAll("<div class='block'></div>");   
        }
         
    });

    FixImages(false);
});

function ShowActions(id) {
    if ($(window).width() > 980) {
        var img_id = '#' + id + ' .tool-box';
        $(img_id).css('display', 'block');
    }
    else {
        // TODO
    }
}

function HideActions(id) {
    if ($(window).width() > 980) {
        var img_id = '#' + id + ' .tool-box';
        $(img_id).css('display', 'none');
    }
    else {
        // TODO
    }
}

function Pick(id) {
    alert("Pick " + id);
}

function Like(id) {
    alert("Like " + id);
}

function Comment(id) {
    alert("Comment " + id);
}

/* Fix images */

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

function StretchImage(div, img) {
    RememberOriginalSize(img);

    var targetwidth = $(div).width();
    var targetheight = $(div).height();

    img.width = targetwidth;
    img.height = targetheight;
    $(img).css("left", 0);
    $(img).css("top", 0);
}

function FixImages(fLetterBox) {
    $("div.box").each(function (index, div) {
        var img = $(div).find("img").get(0);
        FixImage(fLetterBox, div, img);
    });
}

function StretchImages() {
    $("div.box").each(function (index, div) {
        var img = $(div).find("img").get(0);
        StretchImage(div, img);
    });
}
