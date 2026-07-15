<? /*

<a class="screen-reader-only" data-toggle="modal" data-target="#bxr-nov-popup" data-session="<?= !empty($_SESSION['popup_nov1']) ? 1 : 0 ?>" style="cursor: pointer;">Информация о ноябрьских праздниках</a>

<div class="modal bxr-form-modal" id="bxr-nov-popup" tabindex="-1" role="dialog" aria-labelledby="bxr-new-year-popupLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="announcement">
      <div class="announcement__modal-header modal-header">
        <button type="button" class="announcement__close close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="h4 modal-title" id="bxr-new-year-popupLabel"></div>
      </div>

      <div class="announcement__modal-body modal-body">
        <div class="bxr-form-body-container">
          <div class="announcement__title">ДОРОГИЕ ДРУЗЬЯ!</div>
          <div class="announcement__sub-title">Рады приветствовать Вас на нашем сайте!</div>

          <div class="announcement__announcement-box announcement-box">
              <div class="announcement-box__title">6 ноября у нас нерабочий день. </div>
              <div class="announcement-box__text"> Оформленные заказы будут обрабатываться с 7 ноября.</div>
          </div>

          <div class="announcement__footer-title">С Днём народного единства!</div>
        </div>
      </div>
    </div>
  </div>
</div>
</div> 
*/?>

<a class="screen-reader-only" data-toggle="modal" data-target="#bxr-dayoff-popup" style="cursor: pointer;">
    Информация об&nbsp;изменении графика работы
</a>

<div 
    class="modal bxr-form-modal" 
    id="bxr-dayoff-popup" 
    tabindex="-1" 
    role="dialog"
    aria-labelledby="bxr-dayoff-popupLabel"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="announcement">
                <div class="announcement__modal-header modal-header">
                    <button type="button" class="announcement__close close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="h4 modal-title" id="bxr-dayoff-popupLabel"></div>
                </div>

                <div class="announcement__modal-body modal-body">
                    <div class="bxr-form-body-container">
                        <div class="announcement__title">ДОРОГИЕ ДРУЗЬЯ!</div>
                        <div class="announcement__sub-title">Изменения в графике работы:</div>

                        <div class="announcement__announcement-box announcement-box">
                            <div class="announcement-box__title">12 ИЮНЯ У НАС НЕРАБОЧИЙ ДЕНЬ.</div>
                            <?/*<div class="announcement-box__text" style="font-size: 16px;">28 декабря работаем с 10:00 до 19:00 </div>*/?>

                            <div class="announcement-box__text"> Оформленные заказы будут обрабатываться с 15 ИЮНЯ.</div>
                            
                        </div>

                        <div class="announcement__footer-title">С ДНЕМ РОССИИ!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<a class="screen-reader-only" data-toggle="modal" data-target="#bxr-dayoff-popup2" style="cursor: pointer;">
    Информация об&nbsp;изменении графика работы
</a>

<div 
    class="modal bxr-form-modal" 
    id="bxr-dayoff-popup2" 
    tabindex="-1" 
    role="dialog"
    aria-labelledby="bxr-dayoff-popupLabel"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="announcement">
                <div class="announcement__modal-header modal-header">
                    <button type="button" class="announcement__close close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="h4 modal-title" id="bxr-dayoff-popupLabel"></div>
                </div>

                <div class="announcement__modal-body modal-body">
                    <div class="bxr-form-body-container">
                        <div class="announcement__title">ДОРОГИЕ ДРУЗЬЯ!</div>
                        <div class="announcement__sub-title">Изменения в графике работы:</div>

                        <div class="announcement__announcement-box announcement-box">
                            <div class="announcement-box__title">С 9 ПО 11 МАЯ<br> У НАС НЕРАБОЧИЕ ДНИ.</div>
                            <?/*<div class="announcement-box__text" style="font-size: 16px;">28 декабря работаем с 10:00 до 19:00 </div>*/?>

                            <div class="announcement-box__text"> Оформленные заказы будут обрабатываться с 12 МАЯ.</div>
                            
                        </div>

                        <div class="announcement__footer-title">С ДНЕМ ПОБЕДЫ!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php /*
<a class="screen-reader-only" data-toggle="modal" data-target="#bxr-new-year-popup_2"
    style="cursor: pointer;">Информация о новогодних праздниках</a>

<div class="modal bxr-form-modal" id="bxr-new-year-popup_2" tabindex="-1" role="dialog"
    aria-labelledby="bxr-new-year-popupLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="announcement">
                <div class="announcement__modal-header modal-header">
                    <button type="button" class="announcement__close close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="h4 modal-title" id="bxr-new-year-popupLabel"></div>
                </div>

                <div class="announcement__modal-body modal-body">
                    <div class="bxr-form-body-container">
                        <div class="announcement__title">ДОРОГИЕ ДРУЗЬЯ!</div>
                        <div class="announcement__sub-title">Изменения в графике работы:</div>

                        <div class="announcement__announcement-box announcement-box">
                            <div class="announcement-box__title">С 31 ДЕКАБРЯ ПО 11 ЯНВАРЯ У НАС НЕРАБОЧИЕ ДНИ.</div>               
                            <div class="announcement-box__text"> Оформленные заказы будут обрабатываться с 12 января.</div>
                        </div>

                        <div class="announcement__footer-title">С НОВЫМ ГОДОМ и РОЖДЕСТВОМ !</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

$_SESSION['popup_febrary1'] = 1; 

<a class="screen-reader-only" data-toggle="modal" data-target="#bxr-may-popup" style="cursor: pointer;">Информация о
    предновогоднем графике работы</a>
<div class="modal bxr-form-modal" id="bxr-may-popup" tabindex="-1" role="dialog" aria-labelledby="bxr-may-popupLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="announcement">
                <div class="announcement__modal-header modal-header">
                    <button type="button" class="announcement__close close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="h4 modal-title" id="bxr-may-popupLabel"></div>
                </div>

                <div class="announcement__modal-body modal-body">
                    <div class="bxr-form-body-container">
                        <div class="announcement__title">Дорогие друзья!</div>
                        <div class="announcement__sub-title">Изменения в графике работы:</div>

                        <div class="announcement__announcement-box announcement-box">
                            <div class="announcement-box__title">26 ДЕКАБРЯ мы работаем до 13.00.</div>
                            <div class="announcement-box__text">Заказы, оформленные позже, будут обрабатываться с 29
                                Декабря.</div>
                            <div class="announcement-box__text">С уважением, команда Ustage</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="screen-reader-only js-modal-june" data-toggle="modal"  data-session="<?= !empty($_SESSION['popup_24']) ? 1 : 0 ?>" data-target="#bxr-june" style="cursor: pointer;">Информация о 24 апреля</a>

<div class="modal bxr-form-modal" id="bxr-june" tabindex="-1" role="dialog" aria-labelledby="bxr-june-popupLabel">
<div class="modal-dialog modal-dialog-big" role="document">
  <div class="modal-content">
    <div class="announcement">
      <div class="announcement__modal-header modal-header">
        <button type="button" class="announcement__close close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="h4 modal-title" id="bxr-june-popupLabel"></div>
      </div>

      <div class="announcement__modal-body modal-body">
        <div class="bxr-form-body-container">
          <div class="announcement__title">ДОРОГИЕ ДРУЗЬЯ!</div>
          <div class="announcement__sub-title">Изменения в графике работы:</div>

          <div class="announcement__announcement-box announcement-box">
              <div class="announcement-box__text">
                  В связи с отсутствием электричества в нашем магазине 24 апреля,
              </div>
              <div class="announcement-box__text">
                   <strong>мы не сможем с вами встретиться, магазин будет закрыт. :(</strong>
              </div>
              <div class="announcement-box__text">
                  Нам очень жаль, но мы остаемся с Вами на связи! Вы можете оформить заказ по почте или по телефону, а получить его уже завтра - 25 апреля.
              </div>
              <?/*<div class="announcement-box__text announcement-box__text-margin"> 
                  Все оформленные и оплаченные заказы до 19:00 29.06.23 будут отгружены в срок.
              </div>
          </div>

          <div class="announcement__footer-title">Связаться с нами:</div>
          <div class="announcement__footer-flex">
              <span><a href="mailto:sale@ustage-group.ru">sale@ustage-group.ru</a></span>     
              <span><a class="announcement__footer-phone" href="tel:88124094991">8 (812) 409-49-91</a></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

*/ ?>