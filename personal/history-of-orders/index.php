<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("История заказов");
?>
<?
if (!TSolution::isCabinetAvailable()) {
	LocalRedirect(SITE_DIR);
}

if (!TSolution::isPersonalSectionAvailable()) {
	LocalRedirect(SITE_DIR.'auth/');
}

if (!TSolution::isPersonalSaleSectionAvailable()) {
	$url = TSolution::GetFrontParametrValue('PERSONAL_PAGE_URL') ?: SITE_DIR.'personal/';
	LocalRedirect($url.'private/');
}

$_REQUEST["filter_history"] = "Y";
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order", 
	"orders", 
	array(
		"PROP_1" => array(
		),
		"PROP_3" => "",
		"PROP_2" => array(
		),
		"PROP_4" => "",
		"SEF_MODE" => "Y",
		"HISTORIC_STATUSES" => array(
			0 => "N",
			1 => "P",
			2 => "F",
		),
		"SEF_FOLDER" => "/personal/history-of-orders/",
		"ORDERS_PER_PAGE" => "20",
		"PATH_TO_PAYMENT" => "/order/payment/",
		"PATH_TO_BASKET" => "/basket/",
		"SET_TITLE" => "N",
		"SAVE_IN_SESSION" => "Y",
		"NAV_TEMPLATE" => "",
		"COMPONENT_TEMPLATE" => "orders",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"CUSTOM_SELECT_PROPS" => array(
		),
		"SEF_URL_TEMPLATES" => array(
			"list" => "",
			"detail" => "order_detail.php?ID=#ID#",
			"cancel" => "order_cancel.php?ID=#ID#",
		),
		"VARIABLE_ALIASES" => array(
			"detail" => array(
				"ID" => "ID",
			),
			"cancel" => array(
				"ID" => "ID",
			),
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>