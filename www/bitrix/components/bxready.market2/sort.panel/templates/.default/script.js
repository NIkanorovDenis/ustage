$(document).on("click", ".bxr-sort-direction-wrap", function() {
    $('.bxr-sort-type-wrap').toggleClass("visible");
    $(this).toggleClass("bxr-bordered");
    $(this).find('.bxr-direction-wrap-open').toggleClass("fa-angle-down");
    $(this).find('.bxr-direction-wrap-open').toggleClass("fa-angle-up");
})

$(document).on("click", ".bxr-sort-num-direction-wrap", function() {
    $('.bxr-sort-num-wrap').toggleClass("visible");
    $(this).toggleClass("bxr-bordered");
    $(this).find('.bxr-direction-wrap-open').toggleClass("fa-angle-down");
    $(this).find('.bxr-direction-wrap-open').toggleClass("fa-angle-up");
})

$(document).on("click", function() {
    if ($('.bxr-sort-type-wrap').hasClass("visible") && !$(event.target).closest(".bxr-sort-direction-wrap").length)
        $('.bxr-sort-type-wrap').toggleClass("visible");
    if ($('.bxr-sort-num-wrap').hasClass("visible") && !$(event.target).closest(".bxr-sort-num-direction-wrap").length)
        $('.bxr-sort-num-wrap').toggleClass("visible");
})

$(document).on("click", ".bxr-hidden-mobile-btn", function() {
    $('.bxr-sort-panel').fadeToggle();
    $(this).find('i').toggleClass("fa-angle-down");
    $(this).find('i').toggleClass("fa-angle-up");
})