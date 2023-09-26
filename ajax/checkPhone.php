<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");


$order = array('sort' => 'asc');
$tmp = 'sort'; // параметр проигнорируется методом, но обязан быть

$rsUsers = CUser::GetList($order, $tmp, ["PERSONAL_PHONE" => $_POST["PHONE"]])->GetNext();
echo json_encode(["status" => $rsUsers["PERSONAL_PHONE"]]);
