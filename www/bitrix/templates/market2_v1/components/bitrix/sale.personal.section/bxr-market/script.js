$(document).on('click', '.bxr-subscribe-tab-link', function () {
    $('.bxr-subscribe-tab-link').removeClass('bxr-color');
    $(this).addClass('bxr-color');
    tab = $(this).data('tab');
    $('.bxr-subscribe-tab').hide();
    $('.bxr-subscribe-tab[data-tab=' + tab + ']').show();
    history.pushState(null, null, '?type='+tab);
});

