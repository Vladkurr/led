<?
$aMenuLinks = Array(
	Array(
		"Личная информация ", 
		SITE_DIR."/personal/private/", 
		Array(), 
		Array(), 
		"TSolution::isPersonalSectionAvailable()" 
	),
	Array(
		"Текущие заказы", 
		SITE_DIR."/personal/orders/", 
		Array(), 
		Array(), 
		"TSolution::isPersonalSaleSectionAvailable()" 
	),
	Array(
		"История заказов", 
		SITE_DIR."/personal/orders/?filter_history=Y", 
		Array(), 
		Array(), 
		"TSolution::isPersonalSaleSectionAvailable()" 
	),
	Array(
		"Выйти", 
		SITE_DIR."?logout=yes&login=yes", 
		Array(), 
		Array("class"=>"exit", "SVG_ICON"=>"header_icons.svg#logout-11-9"), 
		"\$GLOBALS['USER']->IsAuthorized()" 
	)
);
?>