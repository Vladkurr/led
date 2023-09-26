<?
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$GLOBALS['APPLICATION']->RestartBuffer();
if (!CModule::IncludeModule("iblock")) return;

//$a = CUser::GetByID(18)->GetNext();
//echo "<pre>"; var_dump($a); echo "</pre>";

$user = new CUser;
$pass = "";
for ($i = 0; $i < 10; $i++) {
    $pass .= (string)mt_rand(0,9);
}

$arFields = Array(
    "NAME"              => "Новый покупатель",
    "LOGIN"              => $_REQUEST["PHONE"],
    "LAST_NAME"         => "Новый покупатель",
    "EMAIL"             => $_REQUEST["PHONE"] . "@mail.ru",
    "PERSONAL_PHONE" => "+".$_REQUEST["PHONE"],
    "PHONE_NUMBER" =>$_REQUEST["PHONE"],
    "PASSWORD"          => $pass,
    "CONFIRM_PASSWORD"  => $pass,
);
$ID = $user->Add($arFields);


if(intval($ID) > 0) $user->Authorize($ID);
return json_encode(["status" => intval($ID) > 0,])
//if (intval($ID) > 0)
//    echo "Пользователь успешно добавлен.";
//else
//    echo $user->LAST_ERROR;

?>