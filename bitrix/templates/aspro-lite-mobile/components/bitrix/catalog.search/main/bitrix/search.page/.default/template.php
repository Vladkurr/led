<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $searchQuery;
$searchQuery = $arResult['REQUEST']['QUERY']; // to use this variable in catalog.search`s template

if($arParams["FROM_AJAX"] == "Y"){
	$this->SetViewTarget("search_content");
}

$siteId = defined('SITE_ID') ? SITE_ID : 's1';
$dbSite = CSite::GetByID($siteId);
if($arSite = $dbSite->Fetch()){
	$siteDir = $arSite['DIR'];
}

// catalog page
$catalogPage = trim(TSolution::GetFrontParametrValue("CATALOG_PAGE_URL"));
if(!strlen($catalogPage)){
	// catalog iblock id
	if(defined('URLREWRITE_SEARCH_LANDING_CONDITION_CATALOG_IBLOCK_ID_'.$siteId)){
		$catalogIblockId = constant('URLREWRITE_SEARCH_LANDING_CONDITION_CATALOG_IBLOCK_ID_'.$siteId);
	}
	if(!$catalogIblockId){
		$catalogIblockId = \Bitrix\Main\Config\Option::get(
			'aspro.lite',
			'CATALOG_IBLOCK_ID',
			TSolution\Cache::$arIBlocks[SITE_ID]['aspro_lite_catalog']['aspro_lite_catalog'][0],
			SITE_ID
		);
	}
	if($catalogIblockId && isset(TSolution\Cache::$arIBlocksInfo[$catalogIblockId])){
		$catalogPage = TSolution\Cache::$arIBlocksInfo[$catalogIblockId]['LIST_PAGE_URL'];
	}
}

// catalog page script
$catalogScriptConst = 'ASPRO_CATALOG_SCRIPT_'.$siteId;
$catalogScript = defined($catalogScriptConst) && strlen(constant($catalogScriptConst)) ? constant($catalogScriptConst) : 'index.php';

// catalog full url
$pathFile = str_replace(array('#'.'SITE_DIR#', $catalogScript), array($siteDir, ''), $catalogPage).$catalogScript;
$pathFile = str_replace('/index.php', '/', $pathFile);
?>
<div class="search-page-wrap">
<form class="search " action="<?=($pathFile ? $pathFile : '')?>" method="get">
	<div class="">
		<?if($arParams["USE_SUGGEST"] === "Y"):
			if(strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
			{
				$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
				$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
				$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
			}
			?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:search.suggest.input",
				"",
				array(
					"NAME" => "q",
					"VALUE" => $arResult["REQUEST"]["~QUERY"],
					"INPUT_SIZE" => 40,
					"DROPDOWN_SIZE" => 10,
					"FILTER_MD5" => $arResult["FILTER_MD5"],
				),
				$component, array("HIDE_ICONS" => "Y")
			);?>
		<?else:?>
			<input class="form-control search-input" type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
		<?endif;?>
		<?if($_REQUEST)
		{
			foreach($_REQUEST as $key => $value)
			{
				if($key != "q" && $key != "how" && $key != "section_id")
				{
					if((strpos($key, "section_id") !== false || strpos($key, "searchFilter") !== false || strpos($key, "set_filter") !== false))
					{?>
						<input type="hidden" name="<?=$key;?>" value="<?=$value?>" />
					<?}
				}
			}
		}
		?>
	</div>
	<?/*<button type="submit" class="btn btn-default btn-lg round-ignore"><?=GetMessage("SEARCH_GO")?></button>*/?>
	<div class="search-button-div">
		<button class="btn btn--no-rippple btn-clear-search fill-dark-light-block banner-light-icon-fill light-opacity-hover" type="reset" name="rs">
			<?=TSolution::showSpriteIconSvg(SITE_TEMPLATE_PATH."/images/svg/header_icons.svg#close-9-9", "clear ", ['WIDTH' => 9,'HEIGHT' => 9]);?>
		</button>
		<button class="btn btn-search btn--no-rippple fill-dark-light-block banner-light-icon-fill light-opacity-hover" type="submit" value="<?=GetMessage("SEARCH_GO")?>">
			<?=TSolution::showSpriteIconSvg(SITE_TEMPLATE_PATH."/images/svg/header_icons.svg#search-18-18", "search ", ['WIDTH' => 18,'HEIGHT' => 18]);?>
		</button>
	</div>
	<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
<?if($arParams["SHOW_WHEN"]):?>
	<script>
	var switch_search_params = function()
	{
		var sp = document.getElementById('search_params');
		var flag;

		if(sp.style.display == 'none')
		{
			flag = false;
			sp.style.display = 'block'
		}
		else
		{
			flag = true;
			sp.style.display = 'none';
		}

		var from = document.getElementsByName('from');
		for(var i = 0; i < from.length; i++)
			if(from[i].type.toLowerCase() == 'text')
				from[i].disabled = flag

		var to = document.getElementsByName('to');
		for(var i = 0; i < to.length; i++)
			if(to[i].type.toLowerCase() == 'text')
				to[i].disabled = flag

		return false;
	}
	</script>
	<br /><a class="search-page-params" href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS')?></a>
	<div id="search_params" class="search-page-params" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"]? 'block': 'none'?>">
		<?$APPLICATION->IncludeComponent(
			'bitrix:main.calendar',
			'',
			array(
				'SHOW_INPUT' => 'Y',
				'INPUT_NAME' => 'from',
				'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
				'INPUT_NAME_FINISH' => 'to',
				'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
				'INPUT_ADDITIONAL_ATTR' => 'size="10"',
			),
			null,
			array('HIDE_ICONS' => 'Y')
		);?>
	</div>
<?endif?>
</form>

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<div class="alert alert-info"><?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?></div>
	</div><?
endif;?>
</div>
<?if($arParams["FROM_AJAX"] == "Y"):?>
	<?$this->EndViewTarget();?>
<?endif;?>