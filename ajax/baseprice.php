<?require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\Web\Json,
	Bitrix\Main\SystemException,
	Bitrix\Main\Loader;

$data = json_decode(file_get_contents('php://input'), true);

$ar_res = CPrice::GetBasePrice($data['oid']);

$mes = CurrencyFormat($ar_res["PRICE"], $ar_res["CURRENCY"]);

die(Json::encode($mes));
