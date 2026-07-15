<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

if (!empty($arResult["errorMessage"]))
{
	if (!is_array($arResult["errorMessage"]))
	{
		ShowError($arResult["errorMessage"]);
	}
	else
	{
		foreach ($arResult["errorMessage"] as $errorMessage)
		{
			ShowError($errorMessage);
		}
	}
}
else
{
	if ($arParams['REFRESHED_COMPONENT_MODE'] === 'Y')
	{
		$wrapperId = str_shuffle(substr($arResult['SIGNED_PARAMS'],0,10));
		?>
		<div class="bx-sap" id="bx-sap<?=$wrapperId?>">
			<div class="container-fluid">
				<?
				if ($arParams['SELL_VALUES_FROM_VAR'] != 'Y')
				{
					if ($arParams['SELL_SHOW_FIXED_VALUES'] === 'Y')
					{
						?>
						<div class="row">
							<div class="col-xs-12 sale-acountpay-block">
								<div class="sale-acountpay-title h4"><?= Loc::getMessage("SAP_FIXED_PAYMENT") ?></div>
								<div class="sale-acountpay-fixedpay-container">
									<div class="sale-acountpay-fixedpay-list">
										<?
										foreach ($arParams["SELL_TOTAL"] as $valueChanging)
										{
											?>
											<div class="sale-acountpay-fixedpay-item bxr-border-color bxr-font-color bxr-color-hover">
												<?=CUtil::JSEscape(htmlspecialcharsbx($valueChanging))?>
											</div>
											<?
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<?
					}
					?>
					<div class="row">
						<div class="col-xs-12 sale-acountpay-block form-horizontal">
							<div class="h4 sale-acountpay-title"><?=Loc::getMessage("SAP_SUM")?></div>
							<div class="" style="max-width: 200px;">
								<div class="form-group" style="margin-bottom: 0;">
									<?
									$inputElement = "
										<div class='col-sm-9'>
											<input type='text'	placeholder='0.00'
											class='form-control input-lg sale-acountpay-input' value='0.00' "
											."name=".CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"]))." "
											.($arParams['SELL_USER_INPUT'] === 'N' ? "disabled" :"").
											">
										</div>";
									$tempCurrencyRow = trim(str_replace("#", "", $arResult['FORMATED_CURRENCY']));
									$labelWrapper = "<label class='control-label input-lg input-lg col-sm-3'>".$tempCurrencyRow."</label>";
									$currencyRow = str_replace($tempCurrencyRow, $labelWrapper, $arResult['FORMATED_CURRENCY']);
									$currencyRow = str_replace("#", $inputElement, $currencyRow);
									echo $currencyRow;
									?>
								</div>
							</div>
						</div>
					</div>
				<?
				}
				else
				{
					if ($arParams['SELL_SHOW_RESULT_SUM'] === 'Y')
					{
						?>
						<div class="row">
							<div class="col-xs-12 sale-acountpay-block form-horizontal">
								<div class="sale-acountpay-title h4"><?=Loc::getMessage("SAP_SUM")?></div>
								<div class="h2-personal"><?=SaleFormatCurrency($arResult["SELL_VAR_PRICE_VALUE"], $arParams['SELL_CURRENCY'])?></div>
							</div>
						</div>
						<?
					}
					?>
					<div class="row">
						<input type="hidden" name="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"]))?>"
							class="form-control input-lg sale-acountpay-input"
							value="<?=CUtil::JSEscape(htmlspecialcharsbx($arResult["SELL_VAR_PRICE_VALUE"]))?>">
					</div>
					<?
				}
				?>
				<div class="row">
					<div class="col-xs-12 sale-acountpay-block">
						<div class="sale-acountpay-title h4"><?=Loc::getMessage("SAP_TYPE_PAYMENT_TITLE")?></div>
						<div>
							<div class="sale-acountpay-pp row">
								<div class="col-xs-12 ">
									<?
									foreach ($arResult['PAYSYSTEMS_LIST'] as $key => $paySystem)
									{
										?>
										<div class="sale-acountpay-pp-company col-xl-2 col-lg-2 col-md-3 col-sm-4 col-xs-6 <?= ($key == 0) ? 'bx-selected' :""?>">
											<div class="sale-acountpay-pp-company-graf-container bxr-border-color-hover">
                                                                                                <i class="fa fa-check bxr-font-color" aria-hidden="true"></i>
												<input type="checkbox"
														class="sale-acountpay-pp-company-checkbox"
														name="PAY_SYSTEM_ID"
														value="<?=$paySystem['ID']?>"
														<?= ($key == 0) ? "checked='checked'" :""?>
												>
                                                                                                <div class="sale-acountpay-pp-company-image"
                                                                                                        <?if (isset($paySystem['LOGOTIP'])){?>style="
                                                                                                                background-image: url(<?=$paySystem['LOGOTIP']?>);"
                                                                                                        <?}?>
                                                                                                >
                                                                                                </div>
											</div>
											<div class="sale-acountpay-pp-company-smalltitle">
												<?=CUtil::JSEscape(htmlspecialcharsbx($paySystem['NAME']))?>
											</div>
										</div>
										<?
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<a href="" class="sale-account-pay-button bxr-color-button"><?=Loc::getMessage("SAP_BUTTON")?></a>
					</div>
				</div>
			</div>
		</div>
		<?
		$javascriptParams = array(
			"alertMessages" => array("wrongInput" => Loc::getMessage('SAP_ERROR_INPUT')),
			"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
			"templateFolder" => CUtil::JSEscape($templateFolder),
			"signedParams" => $arResult['SIGNED_PARAMS'],
			"wrapperId" => $wrapperId
		);
		$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
		?>
		<script>
			var sc = new BX.saleAccountPay(<?=$javascriptParams?>);
		</script>
	<?
	}
	else
	{
		?>
		<div class="h4"><?=Loc::getMessage("SAP_BUY_MONEY")?></div>
		<form method="post" name="buyMoney" action="">
			<?
			foreach($arResult["AMOUNT_TO_SHOW"] as $value)
			{
				?>
				<input type="radio" name="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"]))?>"
					value="<?=$value["ID"]?>" id="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"])).$value["ID"]?>">
				<label for="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"])).$value["ID"]?>"><?=$value["NAME"]?></label>
				<br />
				<?
			}
			?>
			<input type="submit" name="button" value="<?=GetMessage("SAP_BUTTON")?>">
		</form>
		<?
	}
}

