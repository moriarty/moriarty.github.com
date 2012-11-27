/**function UpdatePersistHeaderWidth(){
  $(".persist-area").each(function() {
    var el = $(this), 
              floatingHeader = $(".floatingHeader", this)
    floatingHeader.css({
      "width": "100%"
    });
  }
**/
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
}

// DOM Ready      
$(function() {
   $("#topnavlist").tinyNav();
   var clonedHeaderRow;

   $(".persist-area").each(function() {
       clonedHeaderRow = $(".persist-header", this);
       clonedHeaderRow
         .before(clonedHeaderRow.clone())
         .css("width", clonedHeaderRow.width())
         .addClass("floatingHeader");
         
   });
   
   $(window)
    .scroll(UpdateTableHeaders)
    .trigger("scroll");
  $(window)
    .resize(UpdateTableHeaders)
    .trigger("resize");
   
});