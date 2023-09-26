<?
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$GLOBALS['APPLICATION']->RestartBuffer();
require_once 'sms.ru.php';

$smsru = new SMSRU('80237C4D-ABE2-D912-4E79-85E53EE62836'); // Ваш уникальный программный ключ, который можно получить на главной странице

$data = new stdClass();
$data->to = $_REQUEST["PHONE"];

$code = "";
for ($i = 0; $i < 5; $i++) {
    $code .= (string)mt_rand(0,9);
}
$_SESSION["CODE"] = $code;
$data->text = 'Код подтверждения: ' . $code; // Текст сообщения
// $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
// $data->time = time() + 7*60*60; // Отложить отправку на 7 часов
// $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
// $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
// $data->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
//$data->ip = '89.100.111.222'; // IP адрес пользователя, в случае если вы отправляете код авторизации ему на номер в ответ на его запрос (к примеру, при регистрации). В случае аттаки на ваш сайт, наша система сможет помочь с защитой.
$sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную

$el = new CIBlockElement;
//ALL ELEMENT FIELDS
//PROPS WITH UNIQUE ELEMENT CODE
$arLoadProductArray = array(
    'IBLOCK_ID' => 6,
    "NAME" => $sms->status_text,
    "CODE" => $code,
    "ACTIVE" => "Y",
);
$res = $el->Add($arLoadProductArray, false, false, true);
// RETURNS NEW ELEMENT ID


echo json_encode(["status" => 200, "code" => $code, "sms" => $sms->status_text, "phone"=> $_REQUEST["PHONE"]]);

//if ($sms->status == "OK") { // Запрос выполнен успешно
//    $_SESSION["SMS"] = $code;
//    echo "Сообщение отправлено успешно. ";
//} else {
//    echo "Текст ошибки: $sms->status_text.";
//}

?>