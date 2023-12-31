<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

if(!empty($arParams["CUSTOM_PAGES"]) && strpos($arParams["CUSTOM_PAGES"], 'fa-') !== false){
	CJSCore::Init('aspro_font_awesome');
}

/*$APPLICATION->SetTitle(Loc::getMessage("SPS_TITLE_MAIN"));
$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_MAIN"), $arResult['SEF_FOLDER']);

$theme = Bitrix\Main\Config\Option::get("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);*/

$availablePages = array();

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'],
		"name" => Loc::getMessage("SPS_ORDER_PAGE_NAME"),
		//TSolution::showIconSvg("cat_icons light-ignore", $arImg["src"]);
		//"icon" => '<i class="cur_orders"></i>'
		"icon" => TSolution::showIconSvg("cur_orders fill-theme svg-inline-more_icon", SITE_TEMPLATE_PATH.'/images/svg/personal/recent_orders.svg')
	);
}

if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ACCOUNT'],
		"name" => Loc::getMessage("SPS_ACCOUNT_PAGE_NAME"),
		//"icon" => '<i class="bill"></i>'
		"icon" => TSolution::showIconSvg("bill fill-theme svg-inline-more_icon", SITE_TEMPLATE_PATH.'/images/svg/personal/personal_account.svg')
	);
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PRIVATE'],
		"name" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
		//"icon" => '<i class="personal"></i>'
		"icon" => TSolution::showIconSvg("personal fill-theme svg-inline-more_icon", SITE_TEMPLATE_PATH.'/images/svg/personal/personal_data.svg')
	);
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{

	$delimeter = ($arParams['SEF_MODE'] === 'Y') ? "?" : "&";
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'].$delimeter."filter_history=Y",
		"name" => Loc::getMessage("SPS_ORDER_PAGE_HISTORY"),
		//"icon" => '<i class="filter_orders"></i>'
		"icon" => TSolution::showIconSvg("filter_orders fill-theme svg-inline-more_icon", SITE_TEMPLATE_PATH.'/images/svg/personal/orders_history.svg')
	);
}

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PROFILE'],
		"name" => Loc::getMessage("SPS_PROFILE_PAGE_NAME"),
		//"icon" => '<i class="profile"></i>'
		"icon" => TSolution::showIconSvg("profile fill-theme svg-inline-more_icon", SITE_TEMPLATE_PATH.'/images/svg/personal/orders_profiles.svg')
	);
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_BASKET'],
		"name" => Loc::getMessage("SPS_BASKET_PAGE_NAME"),
		//"icon" => '<i class="cart"></i>'
		"icon" => TSolution::showIconSvg("cart fill-theme svg-inline-more_icon", SITE_TEMPLATE_PATH.'/images/svg/personal/basket.svg')
	);
}

if ($arParams['SHOW_SUBSCRIBE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_SUBSCRIBE'],
		"name" => Loc::getMessage("SPS_SUBSCRIBE_PAGE_NAME"),
		//"icon" => '<i class="subscribe"></i>'
		"icon" => TSolution::showIconSvg("subscribes fill-theme svg-inline-more_icon", SITE_TEMPLATE_PATH.'/images/svg/personal/subscribes.svg')
	);
}

if ($arParams['SHOW_CONTACT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_CONTACT'],
		"name" => Loc::getMessage("SPS_CONTACT_PAGE_NAME"),
		//"icon" => '<i class="contact"></i>'
		"icon" => TSolution::showIconSvg("contact fill-theme svg-inline-more_icon", SITE_TEMPLATE_PATH.'/images/svg/personal/contacts.svg')
	);
}

$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList)
{
	foreach ($customPagesList as $page)
	{
		$availablePages[] = array(
			"path" => $page[0],
			"name" => $page[1],
			"icon" => (strlen($page[2])) ? '<i class="fill-theme svg-inline-more_icon fa '.htmlspecialcharsbx($page[2]).'"></i>' : ""
		);
	}
}

if (empty($availablePages))
{
	ShowError(Loc::getMessage("SPS_ERROR_NOT_CHOSEN_ELEMENT"));
}
else
{
	?>
	<div class="personal_wrapper">
		<div class="row sale-personal-section-row-flex">
			<?
			foreach ($availablePages as $blockElement)
			{
				?>
				<div class="col-lg-4 col-md-6 col-sm-12 col-xs-6">
					<div class="sale-personal-section-index-block more_wrapper color-theme-parent-all">
						<a class="sale-personal-section-index-block-link bordered shadow-no-border-hovered outer-rounded-x" href="<?=htmlspecialcharsbx($blockElement['path'])?>">
						<span class="sale-personal-section-index-block-ico">
							<?=$blockElement['icon']?>
						</span>
							<h2 class="sale-personal-section-index-block-name title color-theme-target">
								<?=htmlspecialcharsbx($blockElement['name'])?>
							</h2>
						</a>
					</div>
				</div>
				<?
			}
			?>
		</div>
	</div>
    <a href="?logout=yes&login=yes&sessid=<?= $_SESSION["fixed_session_id"] ?>" class="btn btn-lg has-ripple btn-wide dark_link top-level-link rounded-x  link-with-flag" >выйти</a>
	<?
}
?>
