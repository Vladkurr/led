<?
if (!$templateData['ITEMS']) {
	$GLOBALS['APPLICATION']->SetPageProperty('BLOCK_REVIEWS', 'hidden');
}
TSolution\Extensions::init(['rating']);
?>