$(document).ready(function() {
 
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
});