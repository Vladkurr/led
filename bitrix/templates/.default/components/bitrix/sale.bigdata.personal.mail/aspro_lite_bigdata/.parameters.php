<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters['TITLE'] = array(
	'NAME' => GetMessage('MAIL_TITLE'),
	'TYPE' => 'STRING',
	'REFRESH' => 'N',
	'DEFAULT' => GetMessage('MAIL_TITLE_DEFAULT'),
);

$arTemplateParameters['NOTE'] = array(
	'NAME' => GetMessage('MAIL_NOTE'),
	'TYPE' => 'STRING',
	'REFRESH' => 'N',
	'DEFAULT' => '',
);

$arTemplateParameters['SHOW_BUTTON'] = array(
	'NAME' => GetMessage('MAIL_SHOW_BUTTON'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N',
);

if ($arCurrentValues['SHOW_BUTTON'] === 'Y') {
	$arTemplateParameters['BUTTON_TITLE'] = array(
		'NAME' => GetMessage('MAIL_BUTTON_TITLE'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'DEFAULT' => GetMessage('MAIL_BUTTON_TITLE_DEFAULT'),
	);

	$arTemplateParameters['BUTTON_LINK'] = array(
		'NAME' => GetMessage('MAIL_BUTTON_LINK'),
		'TYPE' => 'STRING',
		'REFRESH' => 'N',
		'DEFAULT' => '/catalog/',
	);
}

$arTemplateParameters['PAGE_ELEMENT_COUNT'] = array(
	'NAME' => GetMessage('MAIL_PAGE_ELEMENT_COUNT'),
	'TYPE' => 'STRING',
	'DEFAULT' => '',
);

$arPrice = [];
if (\Bitrix\Main\Loader::includeModule('catalog')) {
	$arPrice = \CCatalogIBlockParameters::getPriceTypesList();
}
$arTemplateParameters['FILTER_PRICE_CODE'] = array(
	'NAME' => GetMessage('MAIL_FILTER_PRICE_CODE'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'Y',
	'VALUES' => $arPrice,
	'PARENT' => 'PRICES',
);

$arTemplateParameters['SITE_ID'] = array(
	'NAME' => GetMessage('MAIL_SITE_ID'),
	'TYPE' => 'STRING',
	'REFRESH' => 'N',
	'DEFAULT' => '',
);

$arTemplateParameters['SITE_ADDRESS'] = array(
	'NAME' => GetMessage('MAIL_SITE_ADDRESS'),
	'TYPE' => 'STRING',
	'REFRESH' => 'N',
	'DEFAULT' => '',
);

$arTemplateParameters['BASE_COLOR'] = array(
	'NAME' => GetMessage('MAIL_BASE_COLOR'),
	'TYPE' => 'STRING',
	'REFRESH' => 'N',
	'DEFAULT' => '',
);