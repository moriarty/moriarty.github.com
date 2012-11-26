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
       floatingHeader.css({
          "width": width
       })
       if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
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