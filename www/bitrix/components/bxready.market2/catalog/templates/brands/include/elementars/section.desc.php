<div class="row">
    <div class="col-xs-12 bxr-m20">
        
        <?if(strlen($arCurSection["PICTURE"]['src'])>0):?>
            <div class="brands-img">
                <img src="<?=$arCurSection["PICTURE"]['src']?>" align="right">
            </div>
        <?endif;?>
        <div class="bxr-section-desc">
            <?=$arCurSection["DESC"]?>
        </div>
    </div>
</div>