<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(false);

global $arTheme;

TSolution\Extensions::init(['profile']);
?>
<div class="confirmation-page pk-page">
	<?
	//here you can place your own messages
	switch($arResult["MESSAGE_CODE"]){
		case "E01":
			//When user not found
			$class = "alert-warning";
			break;
		case "E02":
			//User was successfully authorized after confirmation
			$class = "alert-success";
			break;
		case "E03":
			//User already confirm his registration
			$class = "alert-warning";
			break;
		case "E04":
			//Missed confirmation code
			$class = "alert-warning";
			break;
		case "E05":
			//Confirmation code provided does not match stored one
			$class = "alert-danger";
			break;
		case "E06":
			//Confirmation was successfull
			$class = "alert-success";
			break;
		case "E07":
			//Some error occured during confirmation
			$class = "alert-danger";
			break;
		default:
			$class = "alert-warning";
	}
	?>
	<div class="form">
		<?if(strlen($arResult["MESSAGE_TEXT"])):?>
			<?$text = str_replace(array("<br>", "<br />"), "\n", $arResult["MESSAGE_TEXT"]);?>
			<div class="alert <?=$class?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
		<?endif;?>

		<?if($arResult["SHOW_FORM"]):?>
			<form id="confirmation-page-form" method="post" action="<?=$arResult['FORM_ACTION']?>">
				<input type="hidden" name="<?=$arParams["USER_ID"]?>" value="<?=$arResult["USER_ID"]?>" />

				<div class="form-body">
					<div class="form-group fill-animate <?=(strlen(strlen($arResult["LOGIN"]) ? $arResult["LOGIN"] : $arResult["USER"]["LOGIN"]) ? 'input-filed' : '')?>">
						<label for="EMAIL_CONFIRM" class="font_14"><?=GetMessage("CT_BSAC_LOGIN")?></label>
						<div class="input">
							<input type="text" name="<?=$arParams["LOGIN"]?>" id="EMAIL_CONFIRM" class="form-control" maxlength="50" value="<?=(strlen($arResult["LOGIN"]) ? $arResult["LOGIN"] : $arResult["USER"]["LOGIN"])?>" size="17" />
						</div>
					</div>

					<div class="form-group fill-animate <?=(strlen($arResult["CONFIRM_CODE"]) ? 'input-filed' : '')?>">
						<label for="CONFIRM_CODE" class="font_14"><?=GetMessage("CT_BSAC_CONFIRM_CODE")?></label>
						<div class="input">
							<input type="text" name="<?=$arParams["CONFIRM_CODE"]?>" id="CONFIRM_CODE" class="form-control" maxlength="50" value="<?=$arResult["CONFIRM_CODE"]?>" size="17" />
						</div>
					</div>
				</div>
				
				<div class="form-footer">
					<button class="btn btn-default btn-lg btn-wide" type="submit" name="confirmation" value="Y"><span><?=GetMessage('CT_BSAC_CONFIRM')?></span></button>
				</div>
			</form>
		<?elseif(!$USER->IsAuthorized()):?>
			<?
			$APPLICATION->IncludeComponent(
				"bitrix:system.auth.form",
				"main",
				Array(
					"REGISTER_URL" => ($arTheme['PERSONAL_PAGE_URL']['VALUE'] ?: SITE_DIR."personal/")."registration/",
					"PROFILE_URL" => ($arTheme['PERSONAL_PAGE_URL']['VALUE'] ?: SITE_DIR."personal/")."forgot-password/",
					"SHOW_ERRORS" => "Y"
				)
			);
			?>
		<?endif;?>

		<script>
		$(document).ready(function(){
			$('#confirmation-page-form').validate({
				highlight: function(element){
					$(element).parent().addClass('error');
				},
				unhighlight: function(element){
					$(element).parent().removeClass('error');
				},
				submitHandler: function(form){
					if($(form).valid()){
						var $button = $(form).find('button[type=submit]');
						if($button.length){
							if(!$button.hasClass('loadings')){
								$button.addClass('loadings');

								var eventdata = {type: 'form_submit', form: form, form_name: 'CONFIRMATION'};
								BX.onCustomEvent('onSubmitForm', [eventdata]);
							}
						}
					}
				},
				errorPlacement: function(error, element){
					error.insertAfter(element);
				},
			});

			setTimeout(function(){
				$('#confirmation-page-form').find('input:visible').eq(0).focus();
			}, 50);
		});
		</script>
	</div>
</div>