$(document).on('click', '.mobile-footer-menu-tumbl', function() {
    $(this).next().toggle();
    var Item = $(this).children("i");
    if (Item.hasClass("fa-chevron-down")) {
      Item.removeClass("fa-chevron-down").addClass("fa-chevron-up");
    }else{
      Item.removeClass("fa-chevron-up").addClass("fa-chevron-down");
    }
});
