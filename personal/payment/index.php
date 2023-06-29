<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Оплата заказа");
?>
<?
if (!TSolution::isCabinetAvailable()) {
	LocalRedirect(SITE_DIR);
}

if (!TSolution::isPersonalSaleSectionAvailable()) {
	$url = TSolution::GetFrontParametrValue('PERSONAL_PAGE_URL') ?: SITE_DIR.'personal/';
	LocalRedirect($url.'private/');
}
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment",
	"",
	Array(
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>