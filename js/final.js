/**function UpdatePersistHeaderWidth(){
  $(".persist-area").each(function() {
    var el = $(this), 
              floatingHeader = $(".floatingHeader", this)
    floatingHeader.css({
      "width": "100%"
    });
  }
**/
function carousel_bg(id) {
     // add images here..
    var bgimgs = [ '1920x625_Sonata_homepage_image.jpg', 
    '1920x625_Equus_homepage_image.jpg', 
    '5_home_hero_1920x625_CF_background.jpg' ];
    var img = bgimgs[id];
    var cnt = 3; // change this number when adding images..

    $('#body').css("background-image", "url(http://www.pitstopmotors.com.ph/images/"+img+")");

    id = id + 1;
    if (id==cnt) id = 0;

    setTimeout("carousel_bg("+id+")", 10000);
  }

function UpdateTableHeaders() {
   $(".persist-area").each(function() {
   
       var el             = $(this),
           offset         = el.offset(),
           scrollTop      = $(window).scrollTop(),
           floatingHeader = $(".floatingHeader", this),
           width = $(this).css("width") // padding is 20 on each side
           mleft = $("#container").css("margin-left")
           mright = $("#container").css("margin-right")
       floatingHeader.css({
          "width": width,
          "opacity": "1"
       })
       floatingHeader.css("left",  $(".persist-header", this).offset().left - $(window).scrollLeft());
       if ((scrollTop > offset.top -31) && (scrollTop < offset.top -31 + el.height())) {
           floatingHeader.css({
            "visibility": "visible"
           });
       } else {
           floatingHeader.css({
            "visibility": "hidden"
           });
       };
   });
}/**
function UpdateSubHeaders() {
   $(".persist-sub-area").each(function() {
   
       var el             = $(this),
           offset         = el.offset(),
           scrollTop      = $(window).scrollTop(),
           floatingHeader = $(".floatingSubHeader", this),
           width = $(this).css("width") // padding is 20 on each side
           mleft = $("#container").css("margin-left")
           mright = $("#container").css("margin-right")
       floatingSubHeader.css({
          "width": width,
          "opacity": "1"
       })
       /*if ((scrollTop > offset.top -31) && (scrollTop < offset.top -31 + el.height())) {
           floatingHeader.css({
            "visibility": "visible"
           });
       } else {
       */ //   floatingSubHeader.css({
        //    "visibility": "hidden"
        //   });
       //};
//   });
//}

// DOM Ready      
$(function() {

  var nav = document.getElementById('topnav'),
        anchor = nav.getElementsByTagName('a'),
        current = window.location.pathname.split('/')[1];
        for (var i = 0; i < anchor.length; i++) {
        if(anchor[i].href == current) {
            anchor[i].className = "active";
        }
    }


  $(document).ready(function() {
    carousel_bg(0);
    /*
    // Create the dropdown base
    $("<select />").appendTo("nav");

    // Create default option "Go to..."
    $("<option />", {
       "selected": "selected",
       "value"   : "",
       "text"    : "Go to..."
    }).appendTo("nav select");

    $("nav a").each(function() {
     var el = $(this);
     $("<option />", {
         "value"   : el.attr("href"),
         "text"    : el.text()
     }).appendTo("nav select");
    });
*/
    $("nav a").each(function() {
     var el = $(this);
     $("<option />", {
         "value"   : el.attr("href"),
         "text"    : el.text()
     }).appendTo("#footnav select");
    });
  });

//   $("#topnavlist").tinyNav();
   var clonedHeaderRow;

   $(".persist-area").each(function() {
       clonedHeaderRow = $(".persist-header", this);
       clonedHeaderRow
         .before(clonedHeaderRow.clone())
         .css("width", clonedHeaderRow.width())
         .addClass("floatingHeader");
         
   });
   /*
   $("#content").each(function() {
       clonedHeaderRow = $(".persist-sub-header", this);
       clonedHeaderRow
         .before(clonedHeaderRow.clone())
         .css("width", clonedHeaderRow.width())
         .addClass("floatingSubHeader");
         
   });
*//*
  $(window)
    .scroll(UpdateSubHeaders)
    .trigger("scroll");
  $(window)
    .resize(UpdateSubHeaders)
    .trigger("resize");
*/
   $(window)
    .scroll(UpdateTableHeaders)
    .trigger("scroll");
  $(window)
    .resize(UpdateTableHeaders)
    .trigger("resize");
   
});