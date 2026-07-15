/*mask phone*/
$(document).on("focus", "form input.phone", 
    function()
    { 
        if(!device.android())
        {
          $(this).mask("+7 (999) 999-99-99");
        }
        
        
    }
);