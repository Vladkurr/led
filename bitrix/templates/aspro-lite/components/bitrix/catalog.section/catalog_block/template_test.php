<?//$APPLICATION->IncludeComponent(
//    "bitrix:catalog.section.list",
//    "home",
//    array(
//        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
//        "IBLOCK_ID"	=> $arParams["IBLOCK_ID"],
//        "CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
//        "CACHE_TIME"	=>	$arParams["CACHE_TIME"],
//        "CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
//        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
//        "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
//        "COUNT_ELEMENTS" => "N",
//        "FILTER_NAME"	=>	$arParams["FILTER_NAME"],
//        "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
//        "TOP_DEPTH" => 1,
//        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
//        "ADD_SECTIONS_CHAIN" => ((!$iSectionsCount || $arParams['INCLUDE_SUBSECTIONS'] !== "N") ? 'N' : 'Y'),
//        "COMPONENT_TEMPLATE" => "main",
//        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
//        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
//        "SECTION_FIELDS" => array(
//            0 => "NAME",
//            1 => "PICTURE",
//            2 => "",
//        ),
//        "SECTION_USER_FIELDS" => array(
//            0 => "UF_CATALOG_ICON",
//            1 => "UF_SVG_INLINE",
//            2 => "",
//        ),
//        "BORDERED" => $bordered,
//        "IMAGES" => $images,
//        "ELEMENTS_IN_ROW" => $elementsInRow,
//        "NARROW" => "Y",
//        "CHECK_REQUEST_BLOCK" => TSolution::checkRequestBlock("catalog_sections"),
//        "IS_AJAX" => TSolution::checkAjaxRequest(),
//        "MOBILE_SCROLLED" => "Y",
//        "MOBILE_COMPACT" => "N",
//        "COMPOSITE_FRAME_MODE" => "A",
//        "COMPOSITE_FRAME_TYPE" => "AUTO"
//    ),
//    false
//);?>