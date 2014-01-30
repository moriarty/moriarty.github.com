/**function UpdatePersistHeaderWidth(){
  $(".persist-area").each(function() {
    var el = $(this), 
              floatingHeader = $(".floatingHeader", this)
    floatingHeader.css({
      "width": "100%"
    });
  }
**/
function carousel_bg() {
    var bgimgs = [ 
    'body-bg-1.png', 'body-bg-2.png', 'body-bg-3.png',
    'body-bg-4.png','body-bg-5.png','body-bg-6.png', 
    'body-bg-7.png', 'body-bg-8.png','body-bg-9.png',
    'body-bg-10.png' ];
    id=Math.floor(Math.random()*bgimgs.length)
    var img = bgimgs[id];
    
    $('#body').css("background-image", "url(./media/"+img+")");

    id=Math.floor(Math.random()*bgimgs.length)

    setTimeout("carousel_bg("+id+")", 60000);
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
       // Fix for when the window is made narrower
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

$(function() {

  $("#sitename").click(function(){
      var loc = $(this).find("a").attr("href");
      if (typeof(loc) != "undefined"){
        window.location = loc;
      } else {
        window.location = "./home.html"
        //window.location = "./index.php" // for www.amoriarty.com home.html is just for final
      }
  });

  var nav = document.getElementById('topnav'),
        anchor = nav.getElementsByTagName('a'),
        current = window.location.pathname.split('/')[1];
        for (var i = 0; i < anchor.length; i++) {
        if(anchor[i].href == current) {
            anchor[i].className = "active";
        }
    }

  Shadowbox.init();
  $(document).ready(function() {

    var d = new Date()
    var age = d.getFullYear() - 1990;
    $("#age").append(age);
  })

  $(document).ready(function() {
    carousel_bg();
    $("nav a").each(function() {
     var el = $(this);
     $("<option />", {
         "value"   : el.attr("href"),
         "text"    : el.text()
     }).appendTo("nav select");
    });

    $("nav a").each(function() {
     var el = $(this);
     $("<option />", {
         "value"   : el.attr("href"),
         "text"    : el.text()
     }).appendTo("#footnav select");
    });
  });

   //$("#topnavlist").tinyNav();
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
   $("nav select").change(function(){
    window.location = $(this).find("option:selected").val();
   })
   $("#footnav select").change(function(){
    window.location = $(this).find("option:selected").val();
   })
});