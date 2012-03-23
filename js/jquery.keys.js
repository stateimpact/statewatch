function scrollToNew () {
  scrollTop = $(window).scrollTop();
  $('.tslide').each(function(i, img){ // loop through images
    imgtop = $(img).offset().top; // get image top
    if (scrollTop < imgtop) { // compare if document is below image
      $.scrollTo(img, 700, { axis:'xy', offset:1 }); // scroll to in .8 of a second
      return false; // exit function
    }
  });
}

function scrollToLast () {
  scrollTop = $(window).scrollTop();

  var scrollToThis = null;

  // Find the last element with class 'tslide' that isn't on-screen:
  $('.tslide').each(function(i, img) {
    imgtop = $(img).offset().top;
    if (scrollTop > imgtop) {
      // This one's not on-screen - make a note and keep going:
      scrollToThis = img;
    } else {
      // This one's on-screen - the last one is the one we want:
      return false;
    }
  });

  // If we found an element in the loop above, scroll to it:
  if(scrollToThis != null) {
    $.scrollTo(scrollToThis, 700);
  }
}


jQuery(function () {

  $("#next").click(scrollToNew);

  $(document).keydown(function (evt) {
    if (evt.keyCode == 40) { // down arrow
      evt.preventDefault(); // prevents the usual scrolling behaviour
      scrollToNew(); // scroll to the next new heading instead
    } else if (evt.keyCode == 38) { // up arrow
      evt.preventDefault();
      scrollToLast();
    }
  });

});

