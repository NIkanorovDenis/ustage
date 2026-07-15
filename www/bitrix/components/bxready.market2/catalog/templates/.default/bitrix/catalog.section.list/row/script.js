$(document).on("click", ".bxr-hidden-slist-mobile-btn", function() {
    $('.bxr-section-list-wrap').fadeToggle();
    $(this).find('i').toggleClass("fa-angle-down");
    $(this).find('i').toggleClass("fa-angle-up");
})