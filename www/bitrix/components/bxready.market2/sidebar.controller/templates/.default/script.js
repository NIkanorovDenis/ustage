(function (window) {

    var counterSideBar = 0;

    if (!!window.initBXReady){

    }else{
        window.initBXReady = function(){
            if (typeof window.BXReady != 'object') {
                return false
            }
            return true;
        }

    }

    BXReadySidebar = {

        ajaxRegistry : [],

        sidebarVisible: false,

        showSidebarPanel : function (){

            //alert(43434);

            if (window.initBXReady){
                this.sidebarVisible = true;
                BXReadySidebar.showElement();
            }
        },

        closeSideBarPanel: function(){
            BXReadySidebar.sidebarVisible = false;
        },

        pushAjax : function (params){
            if (window.initBXReady){

                var current = params;

                BXReadySidebar.ajaxRegistry.push({
                    sidebarName: current.sidebarName,
                    ajaxUrl: current.ajaxUrl,
                    is_ajax : 'y',
                    backurl : current.backurl,
                    siteId: current.siteId,
                    template: current.template,
                    parameters: current.parameters
                });
            }
        },

        showElement : function(){

            pausetInterval = 10000;

            if (BXReadySidebar.ajaxRegistry.length > 0){
                currentSideBar = BXReadySidebar.ajaxRegistry.shift();
                BXReadySidebar.showAjax(currentSideBar);
                setTimeout('BXReadySidebar.showElement()', 100);
            }else{
                if (BXReadySidebar.sidebarVisible){
                    setTimeout('BXReadySidebar.showElement()', pausetInterval);
                }
            }
        },

        showAjax: function(sidebarInfo){

            if (sidebarInfo.ajaxUrl.length > 0){

                sidebarElement = $('div.sidebar-control[data-item='+sidebarInfo.sidebarName+']');
                sidebarElement.removeClass('sidebar-control-empty').addClass('sidebar-control-loader');
                sidebarElement.html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>');
                exportData = '';

                if (typeof(BXReady.Market.exportData) === 'object'){
                    exportData = BXReady.Market.exportData;
                }

                exportData = JSON.stringify(exportData);

                $.ajax(
                    {
                        url: sidebarInfo.ajaxUrl,
                        data: {
                            'rnd' : Math.random(),
                            'sidebarid': sidebarInfo.sidebarName,
                            'backurl': sidebarInfo.backurl,
                            'ajax_mode': 'yes',
                            'export_data': exportData,
                            siteId: sidebarInfo.siteId,
                            template: sidebarInfo.template,
                            parameters: sidebarInfo.parameters

                        },
                        success: function(data){
                            sidebarElement = $('div.sidebar-control[data-item='+sidebarInfo.sidebarName+']');
                            sidebarElement.removeClass('sidebar-control-loader');
                            sidebarElement.html(data);
                        }
                    }
                );

            }
        }

    }


})(window);

