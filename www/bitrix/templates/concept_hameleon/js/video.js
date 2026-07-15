  /*video-modal*/
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  var player = new Array();
  var player_bg = new Array();
  var playerID = 0;

  $(document).on('click', "a.video-close", 
      function ()
          {
              $('div.wrapper').removeClass('blur');
              $('body').removeClass("modal-open"); 
              pauseVideo();
          }
  );
  $(document).mouseup(
      function (e)
      { 
          if($('div.video-modal').hasClass('in')){

              var div = $("div.video-modal.in").find('.modal-dialog'); 
      
              if (!div.is(e.target) && div.has(e.target).length === 0) 
              {
                 
                  $('div.wrapper').removeClass('blur');
                  $('body').removeClass("modal-open");
                  
              }
          }
      }
  );

  $(document).mouseup(
      function (e)
      { 
          if($("div.video-modal").hasClass('in'))
          {
            var div = $("div.modal.in").find('div.modal-dialog'); 

            if (!div.is(e.target) && div.has(e.target).length === 0) 
            {
               pauseVideo()
               
            }
          }
          
              
      }
  ); 

  function onYouTubeIframeAPIReady() {
    

      $('.link-video').each(function(i,elem) 
      {
          $('body').append("<div class='modal video-modal fade' id='video" + i +"'"+"><div class='modal-dialog modal-lg'><div class='modal-content'><div class='m-header'><a  class='video-close' data-dismiss='modal' aria-hidden='true'></a></div><div class='m-body' id='m-body'><div id='player" + i +"'"+"></div></div></div></div></div>");

          $(this).attr("href", '#video'+i);
          $(this).attr("data-id", i);

          var id_video = $(this).attr('data-video');



              player[i] = new YT.Player('player'+i, 
              {
              
                  height: '100%',
                  width: '100%', 
                  videoId: id_video,
                  events: {'onReady': onPlayerReady,'onStateChange': onPlayerStateChange}

              }

          );
    
      });
      
      if($(window).width() >= 1200)
      {
          $('.video-background').each(function(i,elem) 
          {
      
              var id_video = $(this).attr('data-video');
      
              $(this).find('.video-inner').attr('id', 'player_bg'+i);

      
                  player_bg[i] = new YT.Player('player_bg'+i, 
                  {
                  
                          videoId: id_video,
                          playerVars: 
                          {
                              autoplay: "1",
                              controls: '0',
                              disablekb: '0',
                              iv_load_policy: '3',
                              modestbranding: '0',
                              showinfo: '0',
                              rel: '0',
                              loop: '1',
                              playlist: id_video,
                          },
      
                          events: 
                          {
                              'onReady': onPlayerReady2
                          }
      
      
                  }
      
              );
                  
      
        
          });
      }
      
      

  }
  function onPlayerReady2(event) 
  {
      event.target.playVideo();
      event.target.setVolume(0);
  }

  function onPlayerReady(event) 
  {

      $("a.link-video").click(
          function() 
          {
              var playButton = $(this);
              playerID = playButton.attr("data-id");
                  
              player[playerID].setPlaybackQuality("hd720");
              
              if($(window).width() >= 1200)
              {
                  player[playerID].playVideo();
                  play_video = true;
              }
                      

              

              setTimeout(function()
                {
                  resize_video_modal();  
                }, 500);    


            $('div.wrapper').addClass('blur');
            $('body').addClass("modal-open"); 

          
          }
      );
  }

  function onPlayerStateChange(event) 
  {

      if (event.data == YT.PlayerState.PAUSED) 
      {
          pauseVideo();
      }
      else
      {
          
      }

  }

  function pauseVideo() 
  {
      player[playerID].pauseVideo();
      
      play_video = false;    

  }
  /*end video*/

  /*video-bacground-size*/
  $(document).ready(
    function()
    {
      $('div.video-background').each(
        function(){

            var height = $(this).parents('div.video-fon').outerHeight();

            var width = $(window).width();

            var video_w = 0;
            var video_h = 0;


            
            if(width / height < 16 / 9)
            {
                video_w = height * 16 / 9;
                video_h = height;
    
            }
            else
            {
                video_w = width;
                video_h = width * 9 / 16;
            }

            $(this).find('.video-inner').width(video_w).height(video_h);

            

        }
      );
      
    }
  );