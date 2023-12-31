<?
use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Loader::includeModule('iblock');
Loader::includeModule('sale');
Loader::includeModule('currency');

$cp = $this->__component;
if (is_object($cp)) {
	if (empty($arResult['ERRORS']['FATAL'])) {
		$hasDiscount = false;
		$hasProps = false;
		$productSum = 0;
		$basketRefs = array();

		foreach ($arResult["BASKET"] as $k => &$prod) {
			if (floatval($prod['DISCOUNT_PRICE'])) {
				$hasDiscount = true;
			}

			// move iblock props (if any) to basket props to have some kind of consistency
			if (isset($prod['IBLOCK_ID'])) {
				$iblock = $prod['IBLOCK_ID'];

				if (isset($prod['PARENT'])) {
					$parentIblock = $prod['PARENT']['IBLOCK_ID'];
				}

				foreach ($arParams['CUSTOM_SELECT_PROPS'] as $prop) {
					$key = $prop.'_VALUE';
					if (isset($prod[$key])) {
						// in the different iblocks we can have different properties under the same code
						if (isset($arResult['PROPERTY_DESCRIPTION'][$iblock][$prop])) {
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$iblock][$prop];
						}
						elseif (isset($arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop])) {
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop];
						}
						
						if (!empty($realProp)) {
							$prod['PROPS'][] = array(
								'NAME' => $realProp['NAME'], 
								'VALUE' => htmlspecialcharsEx($prod[$key])
							);
						}
					}
				}
			}

			// if we have props, show "properties" column
			if (!empty($prod['PROPS'])) {
				$hasProps = true;
			}

			$productSum += $prod['PRICE'] * $prod['QUANTITY'];

			$basketRefs[$prod['PRODUCT_ID']][] =& $arResult["BASKET"][$k];
		}

		$arResult['HAS_DISCOUNT'] = $hasDiscount;
		$arResult['HAS_PROPS'] = $hasProps;

		$arResult['PRODUCT_SUM_FORMATTED'] = SaleFormatCurrency($productSum, $arResult['CURRENCY']);

		if ($img = intval($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE_ID'])) {

			$pict = CFile::ResizeImageGet($img, array(
				'width' => 150,
				'height' => 90
			), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);

			if (strlen($pict['src'])) {
				$pict = array_change_key_case($pict, CASE_UPPER);
			}

			$arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'] = $pict;
		}

		if ($arResult['PROPERTY_DESCRIPTION']) {
			foreach ($arResult['PROPERTY_DESCRIPTION'] as $key => $arItems) {
				foreach ($arItems as $key2 => $arProp) {
					$arPropNew = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "CODE"=> str_replace("PROPERTY_", "", $key2), "IBLOCK_ID" => 13))->Fetch();
					if ($arPropNew["NAME"]) {
						$arResult['PROPERTY_DESCRIPTION'][$key][$key2]["NAME"] = $arPropNew["NAME"];
					}
				}
			}
		}
	}
}
