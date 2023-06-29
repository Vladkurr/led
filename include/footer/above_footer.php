<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

<?if(
    $APPLICATION->GetProperty('viewed_show') === 'Y'
    || $is404
):?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        array(
            "COMPONENT_TEMPLATE" => "",
            "PATH" => SITE_DIR."include/footer/catalog.viewed.php",
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "",
            "AREA_FILE_RECURSIVE" => "Y",
            "EDIT_TEMPLATE" => "standard.php",
        ),
        false
    );?>
<?endif;?>

<?@include_once('above_footer_custom.php');?>