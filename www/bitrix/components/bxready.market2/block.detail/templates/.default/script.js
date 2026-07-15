function showTab(tabCode){

    $('.bxr-detail-tabs li').removeClass('active');
    $('.bxr-detail-tabs li[data-tab="'+tabCode+'"]').addClass('active');
    $('.bxr-detail-tab').hide();
    $('.bxr-detail-tab[data-tab="'+tabCode+'"]').show(0, function(){
        if(tabCode=="VIDEO")
            $(window).trigger('resizeVideo');
    });
}

var videoResizeState = false;

function resizeTabs(){

    if ($(window).width() < 760){
        $('.bxr-detail-tab').css('display', 'block');
    }else{
        tab = $('.bxr-detail-tabs li.active').data('tab');
        showTab(tab);
    }
}

$(document).on('click', '.bxr-detail-tabs li', function() {

    var tabCode = $(this).data('tab');

    showTab(tabCode);
});

$(document).on('click', '.bxr-detail-top-tabs li', function() {
    var tabCode = $(this).data('tab');
    var tabType = $(this).data('type');

    var tabOffset = 40;

    if (tabType == 'all'){
        window.BXReady.scrollTo('.bxr-detail[data-scroll="'+tabCode+'"]', {offsetTop: 2*tabOffset});
    }else{
        window.BXReady.scrollTo('.bxr-detail-tabs', {offsetTop: 2*tabOffset});
    }

    showTab(tabCode);





});


$(window).resize(function(){
    resizeTabs();
});

resizeTabs();
