/*for footer in slide menu*/
function size_slide_menu()
{
  
  var win_h = $(window).height();
  var tit_h = $('.slide-menu .head-wrap').outerHeight();
  var cont_h = $('.slide-menu .menu-content').outerHeight();
  var foot_h = $('.slide-menu .foot-wrap').outerHeight();

  var total_h = tit_h + cont_h + foot_h;

  if(win_h > total_h)
  {
    $('.slide-menu .inner').css({'min-height': win_h + 'px'});
  }

  else
  {
    $('.slide-menu .inner').css({'min-height': total_h + 'px'});
  }

}

/*for resize modal video*/
function resize_video_modal() 
{
    var win_height = $(window).height();
    var modal = 505;
    
    if($(window).width() < 767)
    {
      modal = 300;
    }
    
    if(win_height>modal)
    {
      var margin_top = (win_height - modal)/2;
      $("div.video-modal.in div.modal-dialog").css({'margin-top': margin_top + 'px'});
    }
    else
    {
      $("div.video-modal.in div.modal-dialog").css({'margin-top': 0 + 'px'});
    }
   
}

$(document).ready(
  function()
  {
  	resize_video_modal();
	  size_slide_menu();
    
  }
);


/* $(window).resize(
//   function()
//   {
//   	size_slide_menu();
//   	resize_video_modal();
    
// 	}
// );*/

