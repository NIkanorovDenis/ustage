(function() {

    window.BXReady.Market.Compare = {

        compareUrl: '/ajax/bxr_compare.php',
        messList: '',
        mess: '',
        iblockID: 0,
        scrollUp: false,
        list: '',

        animateShowIndicator: function (element, sClass) {
            element.css('opacity', '0').addClass(sClass + '-active').animate({'opacity': '1'}, 1000, "easeOutExpo");
        },

        reload: function (notReload) {

            compare = this;

            if (notReload === true) {
                compare.setIndicators();
            } else {
                url = compare.ajaxURL + '?ajaxbuy=yes&rg=' + Math.random();

                $.ajax({
                    url: url,
                    success: function (data) {
                        compare.refresh(data);
                    }
                });
            }
        },

        setIndicators: function() {
            compare = this;
            compare.list = this.startDataCompare;

            $('.bxr-indicator-item-compare').data("compare", 0);
            if (compare.list != null && Object.keys(compare.list).length > 0) {
                $.each(compare.list, function (index, elem) {
                    $('.bxr-indicator-item-compare[data-item=' + index + ']').each(function () {
                        if (!$(this).hasClass('bxr-counter-compare-active'))
                            compare.animateShowIndicator($(this), 'bxr-counter-compare');
                        $(this).removeClass('spinner-wrap');
                        $(this).find(".spinner").attr('class', 'fa fa-bar-chart');
						$(this).addClass('bxr-counter-compare-active bxr-indicator-item-active');
                    });
                    $('.bxr-indicator-item-compare[data-item=' + index + ']').data("compare", 1);
                });
            } else
                $('.bxr-indicator-item-compare').removeClass('bxr-counter-compare-active bxr-indicator-item-active');

            $('.bxr-indicator-item-compare').each(function () {
                if ($(this).data('compare') == 0) {
                    $(this).removeClass('bxr-counter-compare-active bxr-indicator-item-active');
                    $(this).removeClass('spinner-wrap');
                    $(this).find(".spinner").attr('class', 'fa fa-bar-chart');
                }
            });

            $(document).trigger('refreshCompare', compare.list);
        },

        refresh: function (data) {

            compare = this;

            $('#bxr-compare-body').html(data);
            $('#bxr-counter-compare').html($('#bxr-counter-compare-new').html());

            compare.list = JSON.parse($('#bxr-compare-jdata').html());
            compare.startDataCompare = compare.list;

            this.setIndicators();

            BXReady.Market.Basket.autoSetVertical();
        },

        add: function (itemID) {
            compare = window.BXReady.Market.Compare;
            if (
                compare.ajaxURL.length <= 0
                || compare.iblockID <= 0)
                return;

            url = compare.ajaxURL + '?action=ADD_TO_COMPARE_LIST&bid=' + compare.iblockID + '&id=' + itemID + '&ajaxbuy=yes&rg=' + Math.random();

            $.ajax({
                url: url,
                success: function (data) {

                    compare.refresh(data);
                }
            });

            return false;
        },

        delete: function (itemID) {
            
            var compare = this;

            if (
                compare.ajaxURL.length <= 0
                || compare.iblockID <= 0)
                return;

            var url = compare.ajaxURL + '?action=DELETE_FROM_COMPARE_LIST&bid=' + compare.iblockID + '&id=' + itemID + '&ajaxbuy=yes&rg=' + Math.random();

            $.ajax({
                url: url,
                success: function (data) {

                    compare.refresh(data);
                    BXReady.closeAjaxShadow('basket-body-shadow');
                }
            });

            return false;
        },

        init: function () {
            var compare = window.BXReady.Market.Compare;
            compare.reload(true);

            $(document).on(
                'click',
                '.bxr-compare-button',
                function () {

                    var itemID = $(this).data('item');

                    n = 0;

                    if (compare.list == null) {
                    } else {
                        value = parseInt(compare.list[itemID]);
                        if (!isNaN(value) && value > 0)
                            n = 1;
                    }

                    $(this).addClass('spinner-wrap');
                    $(this).find(".fa").attr('class', 'fa spinner wheel');
                    if (!$(this).hasClass('bxr-counter-compare-active'))
                        $(this).addClass('bxr-counter-compare-active bxr-indicator-item-active');

                    if (n == 0) {
                        compare.add(itemID);
                    } else {
                        compare.delete(itemID);
                    }

                    return false;
                }
            );
            $(document).on(
                'click',
                '.compare-button-delete',
                function () {
                    compare = window.BXReady.Market.Compare;
                    itemID = $(this).data('item');

                    BXReady.showAjaxShadow('#bxr-compare-body', 'basket-body-shadow');
                    compare.delete(itemID);
                    return false;
                }
            );
        }
    };
})(jQuery);
