<?
use Bitrix\Main\SystemException;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	include_once '../../../../ajax/const.php';
	require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
}

if (!include_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/vendor/php/solution.php')) {
	throw new SystemException('Error include solution constants');
}
?>
<?$APPLICATION->IncludeComponent(
	"aspro:tabs.lite", 
	".default", 
	array(
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DETAIL_URL" => "",
		"FILTER_NAME" => "arFilterCatalog",
		"HIT_PROP" => "",
		"IBLOCK_ID" => "11",
		"IBLOCK_TYPE" => "aspro_lite_catalog",
		"PARENT_SECTION" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "HIT",
			2 => "BRAND",
			3 => "FORM_ORDER",
			4 => "PRICE",
			5 => "PRICEOLD",
			6 => "ECONOMY",
			7 => "STATUS",
			8 => "SHOW_ON_INDEX_PAGE",
			9 => "ARTICLE",
			10 => "DATE_COUNTER",
			11 => "RECOMMEND",
			12 => "",
		),
		"ELEMENT_SORT_FIELD" => "SORT",
		"ELEMENT_SORT_FIELD2" => "ID",
		"ELEMENT_SORT_ORDER" => "ASC",
		"ELEMENT_SORT_ORDER2" => "ASC",
		"TITLE" => "Хиты продаж",
		"COMPONENT_TEMPLATE" => ".default",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "DETAIL_PICTURE",
			3 => "",
		),
		"ELEMENTS_TABLE_TYPE_VIEW" => "FROM_MODULE",
		"SHOW_SECTION" => "Y",
		"COUNT_IN_LINE" => "4",
		"RIGHT_LINK" => "catalog/",
		"SHOW_DISCOUNT_TIME" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PREVIEW_TEXT" => "N",
		"SHOW_DISCOUNT_PRICE" => "Y",
		"SHOW_GALLERY" => "Y",
		"ADD_PICT_PROP" => "PHOTOS",
		"MAX_GALLERY_ITEMS" => "5",
		"SKU_IBLOCK_ID" => "12",
		"SKU_PROPERTY_CODE" => array(
			0 => "STATUS",
			1 => "PRICE_CURRENCY",
			2 => "PRICE",
			3 => "PRICEOLD",
			4 => "FILTER_PRICE",
			5 => "ECONOMY",
			6 => "MORE_PHOTO",
			7 => "COLOR_REF",
			8 => "SIZES",
			9 => "SIZES4",
			10 => "SIZES5",
			11 => "SIZES3",
		),
		"SKU_TREE_PROPS" => array(
			0 => "COLOR_REF",
			1 => "SIZES",
			2 => "VOLUME",
			3 => "SIZES4",
			4 => "SIZES5",
			5 => "SIZES3",
		),
		"SKU_SORT_FIELD" => "name",
		"SKU_SORT_ORDER" => "asc",
		"SKU_SORT_FIELD2" => "sort",
		"SKU_SORT_ORDER2" => "asc",
		"TYPE_TEMPLATE" => "catalog_block",
		"NARROW" => "FROM_THEME",
		"ITEMS_OFFSET" => "FROM_THEME",
		"TEXT_CENTER" => "FROM_THEME",
		"IMG_CORNER" => "FROM_THEME",
		"ELEMENT_IN_ROW" => "FROM_THEME",
		"COUNT_ROWS" => "FROM_THEME",
		"TABS_FILTER" => "PROPERTY",
		"BORDERED" => "FROM_THEME",
		"ELEMENTS_SOURCE" => "CUSTOM_FILTER",
		"PAGE_ELEMENT_COUNT" => "FROM_THEME",
		"SHOW_TABS" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:11:615\",\"DATA\":{\"logic\":\"Equal\",\"value\":401}}]}"
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"home",
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID"	=> 11,
		"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
		"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
		"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"COUNT_ELEMENTS" => "N",
		"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"TOP_DEPTH" => 1,
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"ADD_SECTIONS_CHAIN" => ((!$iSectionsCount || $arParams['INCLUDE_SUBSECTIONS'] !== "N") ? 'N' : 'Y'),
		"COMPONENT_TEMPLATE" => "main",
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_FIELDS" => array(
			0 => "NAME",
			1 => "PICTURE",
			2 => "",
		),
		"SECTION_USER_FIELDS" => array(
			0 => "UF_CATALOG_ICON",
			1 => "UF_SVG_INLINE",
			2 => "",
		),
		"BORDERED" => $bordered,
		"IMAGES" => $images,
		"ELEMENTS_IN_ROW" => $elementsInRow,
		"NARROW" => "Y",
		"CHECK_REQUEST_BLOCK" => TSolution::checkRequestBlock("catalog_sections"),
		"IS_AJAX" => TSolution::checkAjaxRequest(),
		"MOBILE_SCROLLED" => "Y",
		"MOBILE_COMPACT" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>



