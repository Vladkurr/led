<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранные товары");
?>
<?$APPLICATION->IncludeComponent(
	"aspro:wrapper.block.lite", 
	"favorit", 
	array(
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"ELEMENT_COUNT" => "999",
		"IBLOCK_ID" => "11",
		"IBLOCK_TYPE" => "aspro_lite_catalog",
		"COMPONENT_TEMPLATE" => "favorit",
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>