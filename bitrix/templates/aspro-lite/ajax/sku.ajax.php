<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$sku = CIBlockElement::GetList(["SORT"=>"ASC"], ["ID" => $_POST["ID"]], false, false, ["PROPERTY_TSVET", "NAME"])->GetNext();

echo json_encode([
    "color" => $sku["PROPERTY_TSVET_VALUE"],
    "name" => $sku["NAME"],

]);