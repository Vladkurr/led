<?
$indexPageOptions = $GLOBALS['arTheme']['INDEX_TYPE']['SUB_PARAMS'][ $GLOBALS['arTheme']['INDEX_TYPE']['VALUE'] ];
$blockOptions = $indexPageOptions['TIZERS'];
$blockTemplateOptions = $blockOptions['TEMPLATE']['LIST'][ $blockOptions['TEMPLATE']['VALUE'] ];

$bShowAll = $blockTemplateOptions["ADDITIONAL_OPTIONS"]["LINES_COUNT"]["VALUE"] === 'ALL';
$linesCount = $bShowAll ? 9999 : (intval($blockTemplateOptions["ADDITIONAL_OPTIONS"]["LINES_COUNT"]["VALUE"]) ?: 1);

$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"tizers-list", 
	array(
		"IBLOCK_TYPE" => "aspro_lite_content",
		"IBLOCK_ID" => "3",
		"NEWS_COUNT" => $linesCount*$blockTemplateOptions["ADDITIONAL_OPTIONS"]["ELEMENTS_COUNT"]["VALUE"],
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "arFrontFilter",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DETAIL_TEXT",
			4 => "DETAIL_PICTURE",
			5 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "LINK",
			2 => "TYPE",
			3 => "TIZER_ICON",
			4 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"PAGER_TEMPLATE" => "ajax",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"COMPONENT_TEMPLATE" => "tizers-list",
		"SET_LAST_MODIFIED" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"MOBILE_SCROLLED" => true,
		"FRONT_PAGE" => TSolution::IsMainPage(),
		"IMAGE_POSITION" => "FROM_THEME",
		"ITEMS_COUNT" => "FROM_THEME",
		"THEME" => array(
			"IMAGE_POSITION" => $blockTemplateOptions["ADDITIONAL_OPTIONS"]["IMAGES_POSITION"]["VALUE"],
			"ITEMS_COUNT" => $blockTemplateOptions["ADDITIONAL_OPTIONS"]["ELEMENTS_COUNT"]["VALUE"],
		),
		"USE_FILTER_ELEMENTS" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>