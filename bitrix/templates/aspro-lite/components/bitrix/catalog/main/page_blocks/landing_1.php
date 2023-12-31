<?if(TSolution::isSmartSeoInstalled() && $arParams['SHOW_SMARTSEO_TAGS'] !== 'N'):?>
	<?$APPLICATION->IncludeComponent(
		"aspro:smartseo.tags",
		"lite",
		array(
			"MODE" => "Y",
			"FOLDER" => $arParams['SEF_FOLDER'],
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"SECTION_ID" => $arSection['ID'],
			"CACHE_TYPE" => $arParams['CACHE_TYPE'],
			"CACHE_TIME" => $arParams['CACHE_TIME'],
			"URL_TEMPLATES" => $arParams['SEF_URL_TEMPLATES'],
			"SHOW_VIEW_CONTENT" => 'N',
			"CODE_VIEW_CONTENT" => 'smartseo',
			"VIEW_TYPE" => 'normal', //$arTheme['CATALOG_PAGE_LANDINGS_VIEW']['VALUE'],
			"SHOW_COUNT" => $arParams['SMARTSEO_TAGS_COUNT'],
			"SHOW_COUNT_MOBILE" => $arParams['SMARTSEO_TAGS_COUNT_MOBILE'],
			"SHOW_BY_GROUPS" => $arParams['SMARTSEO_TAGS_BY_GROUPS'],
			"SHOW_DEACTIVATED" => $arParams['SMARTSEO_TAGS_SHOW_DEACTIVATED'],
			"SORT" => $arParams['SMARTSEO_TAGS_SORT'],
			"LIMIT" => $arParams['SMARTSEO_TAGS_LIMIT'],
			"TITLE_BLOCK" => (!isset($arParams['LANDING_POSITION']) || $arParams['LANDING_POSITION'] !== 'BEFORE_PRODUCTS') ? $arParams['LANDING_TITLE'] : '',
			"BG_FILLED" => 'N',
		),
		false, array("HIDE_ICONS" => "Y")
	);?>
<?endif;?>

<?if($arParams['SHOW_LANDINGS'] !== 'N'):?>
	<?if($arSeoItems):?>
		<?
		$arLandingFilter = array();
		if($arSeoItem)
		{
			// $arTmpRegionsLanding[] = $iLandingItemID;
			$arLandingFilter = array(
				array(
					"LOGIC" => "OR",
					array("PROPERTY_SECTION" => false),
					array("PROPERTY_SECTION" => $arSeoItem["PROPERTY_SECTION_VALUE"] ? $arSeoItem["PROPERTY_SECTION_VALUE"] : $arSection["ID"]),
				),
				"!ID" => $arTmpRegionsLanding,
			);
		}
		else
		{
			$arLandingFilter = array(
				array(
					"LOGIC" => "OR",
					array("PROPERTY_SECTION" => false),
					array("PROPERTY_SECTION" => $arSection["ID"]),
				),
				"!ID" => $arTmpRegionsLanding,
			);
		}
		?>
		<?$GLOBALS["arLandingSections"] = $arLandingFilter;?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"landings_list",
			array(
				"IBLOCK_TYPE" => "aspro_lite_catalog",
				"IBLOCK_ID" => $arParams["LANDING_IBLOCK_ID"],
				"NEWS_COUNT" => $arParams["LANDING_SECTION_COUNT"],
				"CUR_PAGE" => $APPLICATION->GetCurPage(),
				"SHOW_COUNT" => $arParams["LANDING_SECTION_COUNT_VISIBLE"],
				"COMPARE_FIELD" => "FILTER_URL",
				"COMPARE_PROP" => "Y",
				"SORT_BY1" => "SORT",
				"SORT_ORDER1" => "ASC",
				"SORT_BY2" => "ID",
				"SORT_ORDER2" => "DESC",
				"FILTER_NAME" => "arLandingSections",
				"FIELD_CODE" => array(
					0 => "",
					1 => "",
				),
				"PROPERTY_CODE" => array(
					0 => "LINK",
					1 => "",
				),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"CACHE_TYPE" =>$arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"SEF_CATALOG_URL" => $arResult["URL_TEMPLATES"]["smart_filter"],
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
				"INCLUDE_SUBSECTIONS" => "Y",
				"PAGER_TEMPLATE" => "",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"COMPONENT_TEMPLATE" => "next",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_LAST_MODIFIED" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => ""
			),
			false, array("HIDE_ICONS" => "Y")
		);?>
	<?endif;?>
<?endif;?>