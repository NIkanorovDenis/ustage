<?$APPLICATION->SetTitle(GetMessage("EXPIRED_TITLE"));?>

<?
use \Bitrix\Main\Localization\Loc as Loc;
Loc::loadMessages(__FILE__);
?>


<div class="expired-page">

    <div class="expired-shadow"></div>
    
    <div class="container">
        <div class="row">
            
            <table>
                <tr>
                    <td>
                        
                        <div class="expired-container col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            
                            <div class="logo">
                                <img class="img-responsive center-block" src="<?=SITE_TEMPLATE_PATH?>/images/logo-expired.png" />
                            </div>
                            
                            <div class="clearfix"></div>
                            
                            <div class="first-text col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">
                                <?=GetMessage("EXPIRED1")?>
                            </div>
                            
                            <div class="clearfix"></div>
                            
                            <div class="expired-form col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">
                                <a class="button" href="http://marketplace.1c-bitrix.ru/solutions/concept.hameleon/" target="_blank"><?=GetMessage("EXPIRED_BUTTON")?></a>
                            
                            </div>
                            
                            
                            <div class="clearfix"></div>
                            
                            <div class="second-text col-lg-6 col-md-6 col-sm-8 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-2 col-xs-offset-0">
                                <?=GetMessage("EXPIRED2")?>
                            </div>
                            
                            <div class="clearfix"></div>

                        </div>
                        
                        <div class="bottom-links">
                                
                            <div class="link">
                                <a href="http://marketplace.1c-bitrix.ru/solutions/concept.hameleon/" target="_blank"><?=GetMessage("EXPIRED_LINK")?></a>
                            </div>
                            
                        </div>
                        
                    </td>
                </tr>
            </table>
            
        </div>
    </div>
</div>

