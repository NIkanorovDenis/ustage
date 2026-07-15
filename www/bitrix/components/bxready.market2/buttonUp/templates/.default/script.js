$(document).ready(function(){
    
    window.BXReady.Market.buttonUp =  {
                 
        init: function(top_show, delay, button_up){
            
            buttonUp = $('.bxr-button-up');

            $(window).scroll(function () {

                if ($(this).scrollTop() > top_show)
                    buttonUp.fadeIn();
                else
                    buttonUp.fadeOut();
            });
           
                
            buttonUp.click(function () {
                $('body, html').animate({
                    scrollTop: 0
                }, delay);
             });         
        },
    };
});