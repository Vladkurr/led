<?php
use \Bitrix\Main\Localization\Loc;
?>
<? if ($templateData['SERVICES'] && $templateData['SERVICES']['IBLOCK_ID'] && $templateData['SERVICES']['VALUE']): ?>
	<? $GLOBALS['arrServicesFilter'] = ['ID' => $templateData['SERVICES']['VALUE']]; ?>
	<? ob_start(); ?>
	<?$bCheckAjaxBlock = TSolution::checkRequestBlock("services-list-inner");?>
	<? $APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"blog-list",
		array(
			"IBLOCK_TYPE" => "aspro_lite_content",
			"IBLOCK_ID" => $templateData['SERVICES']['IBLOCK_ID'],
			"NEWS_COUNT" => "20",
			"SORT_BY1" => "SORT",
			"SORT_ORDER1" => "ASC",
			"SORT_BY2" => "ID",
			"SORT_ORDER2" => "DESC",
			"FILTER_NAME" => "arrServicesFilter",
			"FIELD_CODE" => array(
				0 => "NAME",
				1 => "PREVIEW_TEXT",
				2 => "PREVIEW_PICTURE",
				3 => "DATE_ACTIVE_FROM",
				4 => "",
			),
			"PROPERTY_CODE" => array(
				0 => "PRICE",
				1 => "PRICEOLD",
				2 => "ECONOMY",
				3 => "PERIOD",
				4 => "REDIRECT",
				5 => "",
			),
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => "N",
			"PREVIEW_TRUNCATE_LEN" => "",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"INCLUDE_SUBSECTIONS" => "Y",
			"PAGER_TEMPLATE" => ".default",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"COUNT_IN_LINE" => "2",

			"ROW_VIEW" => true,
			"BORDER" => true,
			"DARK_HOVER" => false,
			"ITEM_HOVER_SHADOW" => true,
			"ROUNDED" => true,
			"ROUNDED_IMAGE" => true,
			"ITEM_PADDING" => true,
			"ELEMENTS_ROW" => 1,
			"MAXWIDTH_WRAP" => "N",
			"MOBILE_SCROLLED" => false,
			"NARROW" => false,
			"ITEMS_OFFSET" => false,
			"IMAGES" => "PICTURE",
			"IMAGE_POSITION" => "LEFT",
			"SHOW_PREVIEW" => false,
			"SHOW_TITLE" => false,
			"SHOW_SECTION" => "N",
			"PRICE_POSITION" => "RIGHT",
			"TITLE_POSITION" => "",
			"TITLE" => "",
			"RIGHT_TITLE" => "",
			"RIGHT_LINK" => "",
			"CHECK_REQUEST_BLOCK" => $bCheckAjaxBlock,
			"IS_AJAX" => TSolution::checkAjaxRequest() && $bCheckAjaxBlock,
			"NAME_SIZE" => "18",
			"SUBTITLE" => "",
			"SHOW_PREVIEW_TEXT" => "N",
		),
		false, array("HIDE_ICONS" => "Y")
	); ?>
	<? $html = trim(ob_get_clean()); ?>
	<? if ($html && strpos($html, 'error') === false): ?>
		<div class="detail-block ordered-block">
			<h3 class="switcher-title"><?=$arParams['T_SERVICES'] ?: Loc::getMessage('EPILOG_BLOCK__SERVICES') ?></h3>
			<?= $html ?>
		</div>
	<? endif; ?>
<? endif; ?>