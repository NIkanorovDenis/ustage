function setPanelClasses() {
    rightPanelDefClasses = {
        first: 'bxr-right-panel-xl-first',
        second: 'bxr-right-panel-xl-second',
        third: 'bxr-right-panel-xl-third'
    };

    lessXlClasses = {
        rightColId: 'bxr-right-col-disabled',
        rightCol: 'bxr-col-panel bxr-right-panel bxr-right-panel-v1 hidden-sm hidden-xs',
        content: 'bxr-right-panel-content',
        scroll: 'bxr-content-block bxr-content-scroll',
        scrollRemove: 'scroll-wrapper',
        scrollContentRemove: 'scroll-content'
    };

    xlClasses = {
        rightColId: 'bxr-right-col',
        rightCol: 'col-xl-2 bxr-right-col bxr-right-col-show',
        cloud: 'bxr-cloud-all bxr-cloud-padding bxr-b20',
        sticky: 'bxr-sticky-col',
        scrollRemove: 'bxr-removed-scroll'
    };

    if (window.innerWidth >= 1780 && BXReady.coreData.xl_mode && BXReady.coreData.right_column == "Y") {
        xlAttr = $('.bxr-right-panel-xl').attr('style');
        $('.bxr-right-panel-xl').data('scroll-style', xlAttr);

        scwAttr = $('.'+lessXlClasses.scrollRemove).attr('style');
        $('.bxr-right-panel-xl').data('scroll-wrapper', scwAttr);

        scAttr = $('.'+lessXlClasses.scrollContentRemove).attr('style');
        $('.bxr-right-panel-xl').data('scroll-content', scAttr);

        $('.bxr-right-panel-xl').removeAttr('style');
        $('.bxr-right-panel-xl').removeClass(lessXlClasses.rightCol);
        $('.bxr-right-panel-xl').addClass(xlClasses.rightCol);

        $('.bxr-right-panel-xl .'+rightPanelDefClasses.first).removeClass(lessXlClasses.content);
        $('.bxr-right-panel-xl .'+rightPanelDefClasses.first).addClass(xlClasses.cloud);

        if ($('.bxr-right-panel-xl .'+rightPanelDefClasses.first+'>div').hasClass(lessXlClasses.scrollRemove)) {
            $('.bxr-right-panel-xl .'+rightPanelDefClasses.first+'>div').removeAttr('class');
            $('.bxr-right-panel-xl .'+rightPanelDefClasses.first+'>div').removeAttr('style');
            $('.bxr-right-panel-xl .'+rightPanelDefClasses.first+'>div').addClass(xlClasses.scrollRemove);
        }

        $('.bxr-right-panel-xl .'+rightPanelDefClasses.second).removeClass(lessXlClasses.scroll);
        $('.bxr-right-panel-xl .'+rightPanelDefClasses.second).removeClass(lessXlClasses.scrollContentRemove);
        $('.bxr-right-panel-xl .'+rightPanelDefClasses.second).removeAttr('style');

        if ($('#bxr-right-col').length == 0) {
            $('.bxr-right-panel-xl').attr('id', xlClasses.rightColId);

            if (!$('.bxr-right-panel-xl>div').hasClass(rightPanelDefClasses.first)) {
                scrollStyle = $('.bxr-right-panel-xl').data('sticky-style');
                if (scrollStyle != "")
                    $('.bxr-right-panel-xl>div').attr('style', scrollStyle);
                $('.bxr-right-panel-xl>div').addClass(xlClasses.sticky);
            }

        }
        if (typeof(BXReadySidebar) === 'object') {
            BXReadySidebar.showSidebarPanel();
        }
    } else {
        if (!$('.bxr-right-panel-xl>div').hasClass(rightPanelDefClasses.first)) {
            scrollStyle = $('.bxr-right-panel-xl>div').attr('style');
            $('.bxr-right-panel-xl').data('sticky-style', scrollStyle);
            $('.bxr-right-panel-xl>div').removeAttr('class');
            $('.bxr-right-panel-xl>div').removeAttr('style');
        }
        $('.bxr-right-panel-xl').removeAttr('style');
        $('.bxr-right-panel-xl .'+rightPanelDefClasses.first).removeClass(xlClasses.cloud);

        $('.bxr-right-panel-xl').attr('id', lessXlClasses.rightColId);
        $('.bxr-right-panel-xl').removeClass(xlClasses.rightCol);
        $('.bxr-right-panel-xl').addClass(lessXlClasses.rightCol);
        $('.bxr-right-panel-xl .'+rightPanelDefClasses.first).addClass(lessXlClasses.content);
        $('.bxr-right-panel-xl .'+rightPanelDefClasses.second).addClass(lessXlClasses.scroll);
        $('.bxr-right-panel-xl .'+rightPanelDefClasses.second).addClass(lessXlClasses.scrollContentRemove);

        xlAttr = $('.bxr-right-panel-xl').data('scroll-style');
        if (xlAttr != "")
            $('.bxr-right-panel-xl').attr('style', xlAttr);

        scwAttr = $('.bxr-right-panel-xl').data('scroll-wrapper');

        scAttr = $('.bxr-right-panel-xl').data('scroll-content');
        if (scAttr != "")
            $('.'+lessXlClasses.scroll).attr('style', scAttr);

        if ($('.bxr-right-panel-xl .'+rightPanelDefClasses.first+'>div').hasClass(xlClasses.scrollRemove)) {
            $('.bxr-right-panel-xl .'+rightPanelDefClasses.first+'>div').removeClass(xlClasses.scrollRemove);
            $('.bxr-right-panel-xl .'+rightPanelDefClasses.first+'>div').removeClass(lessXlClasses.scrollContentRemove);
            $('.bxr-right-panel-xl .'+rightPanelDefClasses.first+'>div').addClass(lessXlClasses.scrollRemove);
            $('.bxr-right-panel-xl .'+rightPanelDefClasses.first+'>div').addClass(lessXlClasses.scroll);
            if (scwAttr != "")
                $('.'+lessXlClasses.scrollRemove).attr('style', scwAttr);
        }

        setRightPanelContentMaxHeight();
        setLeftMarginRightPanel();
    }
}

var pageContentBlock = ".bxr-page-content";
    rightOrigin = -290,
    rightBlock = ".bxr-right-panel",
    rightPanelBtn = ".bxr-right-panel-btn-on-top",
    closeMenu = false,
    adminPanelHeight = $('#panel').height();
    topFixedPanelHeight = $(".bxr-top-fixed-panel").height(),
    scrollSpeed = 30;

function rightPanelClose() {
    $(".bxr-right-panel-content").css("right", rightOrigin+"px");
}

$(document).on("click", rightPanelBtn, function() {
    if ($(this).data("state") == "minimized") {
        var hTop = $('.bxr-header-panel').offset().top;
        var hHeight = $('.bxr-header-panel').height();
        var rTop = hTop + hHeight;
        $(rightBlock).css("top", rTop + "px");
        $(pageContentBlock).addClass('visible-right-panel');
        setRightPanelContentMaxHeight();
        $(rightBlock).show('50', function() {
            $(".bxr-right-panel-content").css("right", "-1px");
        });

        if (typeof(BXReadySidebar) === 'object') {
            BXReadySidebar.showSidebarPanel();
        }

    } else if ($(this).data("state") == "maximized") {
        $(rightBlock).removeClass('bxr-diamond-shadow');
        rightPanelClose();
        if (typeof(BXReadySidebar) === 'object') {
            BXReadySidebar.closeSideBarPanel();
        }
    }
})

$(document).on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", ".bxr-right-panel-content",function(event){
    if (!$(event.target).hasClass("bxr-right-panel-content")) return;
    if ($(rightPanelBtn).data("state") == "minimized") {
        $(rightPanelBtn).data("state", "maximized");
        $(rightBlock).addClass('bxr-diamond-shadow');
    } else if ($(rightPanelBtn).data("state") == "maximized") {
        $(rightPanelBtn).data("state", "minimized");
        $(rightBlock).hide();
        $(pageContentBlock).removeClass('visible-right-panel');
    }
});

function setRightPanelContentMaxHeight() {
    bottomBlock = $('.bxr-right-panel .bxr-bottom-block');
    topBlock = $('.bxr-right-panel .bxr-top-block');
    allHeight = $('.bxr-right-panel').height();
    bHeight = bottomBlock.height();
    tHeight = topBlock.height();
    topHeight = $(".bxr-header-panel").height() + $('#panel').height();

    bottomBlock.css("bottom", topHeight+'px');

    $('.bxr-right-panel-content .bxr-content-scroll').scrollbar();
    sHeight = allHeight - (tHeight + bHeight + topHeight);
    bodyHeight = $('body').height();
    sHeight = (bodyHeight < sHeight) ? bodyHeight : sHeight;

    sHeight = bodyHeight - topHeight;

    $('.bxr-right-panel-content .scroll-content').closest('.scroll-wrapper').find('.scroll-content').css('height', sHeight+'px');
    $('.bxr-right-panel-content .scroll-content').closest('.scroll-wrapper').find('.scroll-content').css('max-height', sHeight+'px');
    $('.bxr-right-panel-content .scroll-content').closest('.scroll-wrapper').css('height', sHeight+'px');
    $('.bxr-right-panel-content .scroll-content').closest('.scroll-wrapper').css('max-height', sHeight+'px');
    $('.bxr-right-panel').css('height', sHeight+'px');

    $('.scroll-bar').addClass('bxr-color');
}

function setLeftMarginRightPanel() {
    if (rightBlock && $('.bxr-page-content') && $('.bxr-page-content').offset() != undefined) {
        offset = $('.bxr-page-content').offset().left;
        offset = Math.ceil(offset);
        rWidth = parseInt($('.bxr-page-content').css('width'));
        rMargin = parseInt($('.bxr-page-content').css('margin-left'));
        newLeft = offset + rWidth + rightOrigin + rMargin;
        rWidth = parseInt($(rightBlock).css('left', newLeft + 'px'));
    }
}

$(window).on("load", function() {
    setPanelClasses();
})

$(window).on ('resize', function() {
    setPanelClasses();
});

var inScrollContent = false, scrollContent = false;

$(document).on("click", "body", function(event) {
    if ($(event.target).closest(rightBlock).length)
            return;
    if ($(rightPanelBtn).data("state") == "maximized")
            rightPanelClose();
});

/* --- Jivo position --- */

$(window).resize(function(){
    jivo_bottom();
});

function jivo_bottom(){
    if ($('.info-panel-v').length > 0 && $('.info-panel-v').css('display') == 'block') {
        var h = $('.info-panel-v').outerHeight();
        $('#jvlabelWrap').addClass('jvlabelWrapBtm');
    }
}

function jivo_onLoadCallback() {
     setTimeout(function(){
        jivo_bottom();
     }, 100)
}

function jivo_onOpen(){
    setTimeout(function(){
        jivo_bottom();
     }, 100)
}

function jivo_onClose(){
     setTimeout(function(){
        jivo_bottom();
     }, 100)
}
