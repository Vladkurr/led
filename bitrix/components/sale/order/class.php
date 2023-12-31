<?php
/*
 * Простой компонент оформления заказа, html которого формируется не js кодом, а php.
 *
 * Вывод свойств:
 *  свойства фильтруются в соответствии с выставленными параметрами в настройках компонента.
 *  разделение по плательщиками сделано генерацией нескольких форм, а не изменением полей одной.
 *  если не выбрать способ доставки или оплату, то выбранной будет считаться первая выведенная.
 *
 * Оформление заказа:
 *  1. в js файле шаблона компонента происходит формирование массива формы
 *  2. отправка запроса к текущей странице с сформированным массивом заказа, в который добавляется параметр MAKE_ORDER
 *  3. при получении параметра MAKE_ORDER, компонент вызывает метод создания заказа с параметрами из массива
 *  4. метод создания заказа вызывает другие методы, которые добавляют к нему отгрузки, платежные системы и т.д.
 *
 * Примечания:
 *  Компонент отлично работает со стандартной корзиной битрикса
 *
 * При оформлении заказа происходит проверка на авторизацию пользователя, если пользователь не авторизован,
 * то компонент создаст пользователя Unknown или добавит заказ к существующему
 */


use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use Bitrix\Sale;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class LightSale extends CBitrixComponent
{
    // проверка подключения модуля sale
    private function _checkModules()
    {
        if (!Loader::includeModule('sale')) {
            throw new \Exception('Не загружены модули необходимые для работы модуля');
        }
        return true;
    }

    //возвращает id зарегистрированного пользователя. Если пользователь не авторизован - id общего пользователя "Unknown"
    public function GetUserId()
    {
        global $USER;
        $unauthorizedUser = CUser::GetList(['sort' => 'asc'], 'sort', ["LOGIN" => "Unknown"])->fetch();
        if (!$USER->GetID() && !$unauthorizedUser) {
            $user = new CUser;
            $arFields = array(
                "NAME" => "Неавторизованный пользователь",
                "LOGIN" => "Unknown",
                "LID" => "ru",
                "ACTIVE" => "Y",
                "PASSWORD" => "UnknownUser",
                "CONFIRM_PASSWORD" => "UnknownUser",
            );
            $ID = $user->Add($arFields);
        } elseif (!$USER->GetID() && $unauthorizedUser) {
            $ID = $unauthorizedUser["ID"];
        } else $ID = $USER->GetID();
        return $ID;
    }

    // получение всего списка доставок с учетом ограничений по типам плательщиков ограничениями.
    public function GetDeliveries($payer = null, $paySystemsForDelivery = null)
    {
        $deliveries = Sale\Delivery\Services\Manager::getActiveList();
        foreach ($deliveries as $key => &$delivery) {
            $dbRestr = \Bitrix\Sale\Delivery\Restrictions\Manager::getList(array(
                'filter' => array('SERVICE_ID' => $delivery['ID']) // ID службы доставки
            ));
            $params = [];
            while ($arRestr = $dbRestr->fetch()) {
                if(!$arRestr["PARAMS"]) {
                    $arRestr["PARAMS"] = array();
                }
                $param = $arRestr["CLASS_NAME"]::prepareParamsValues($arRestr["PARAMS"], $delivery['ID']); // Получаем платежные системы
                $params = array_merge($param, $params);
            }
            $params["PAY_SYSTEMS"] ? $delivery["PAY_SYSTEMS"] = $params["PAY_SYSTEMS"] : $delivery["PAY_SYSTEMS"] = [];
            $params["PERSON_TYPE_ID"] ? $delivery["PERSON_TYPE_ID"] = $params["PERSON_TYPE_ID"] : $delivery["PERSON_TYPE_ID"] = [];
        }

        if ($this->arParams["DELIVERIES"]) {
            foreach ($deliveries as $key => &$delivery) {
                if (!in_array($delivery["ID"], $this->arParams["DELIVERIES"])) unset($deliveries[$key]);
            }
        }
        if ($payer) {
            foreach ($deliveries as $key => &$delivery) {
                if (!$delivery["PERSON_TYPE_ID"]) continue;
                if (!in_array($payer, $delivery["PERSON_TYPE_ID"])) unset($deliveries[$key]);
            }
        }
        if ($paySystemsForDelivery) {
            foreach ($deliveries as $key => &$delivery) {
                if (!in_array($delivery["ID"], $paySystemsForDelivery)) unset($deliveries[$key]);
            }
        }

        return $deliveries;
    }

    // получение всего списка платежных систем с учетом ограничений по типам плательщиков.
    public function GetPaySystems($payer = null, $paySystemsForDelivery = null)
    {
        $paySystemResult = Sale\PaySystem\Manager::getList(array('filter' => array('ACTIVE' => 'Y',)));
        while ($paySystem = $paySystemResult->fetch()) {
            $dbRestr = \Bitrix\Sale\Internals\ServiceRestrictionTable::getList(array(
                'filter' => array(
                    'SERVICE_ID' => $paySystem['ID'],
                    'SERVICE_TYPE' => \Bitrix\Sale\Services\PaySystem\Restrictions\Manager::SERVICE_TYPE_PAYMENT
                )
            ));
            $restrictions = array();
            while ($restriction = $dbRestr->fetch()) {
                if (is_array($restriction['PARAMS']))
                    $restrictions = array_merge($restrictions, $restriction['PARAMS']);
            }
            $restriction = \Bitrix\Sale\Services\PaySystem\Restrictions\Delivery::prepareParamsValues(array(), $paySystem['ID']);
            $restrictions['DELIVERY'] = $restriction['DELIVERY'];

            $restrictions["PERSON_TYPE_ID"] ? $paySystem["PERSON_TYPE_ID"] = $restrictions["PERSON_TYPE_ID"] : $paySystem["PERSON_TYPE_ID"] = [];
            $restrictions["DELIVERY"] ? $paySystem["DELIVERY"] = $restrictions["DELIVERY"] : $paySystem["DELIVERY"] = [];
            $paySystems[] = $paySystem;
        }
        if ($this->arParams["PAYSYSTEMS"]) {
            foreach ($paySystems as $key => $paySystem) {
                if (!in_array($paySystem["ID"], $this->arParams["PAYSYSTEMS"])) unset($paySystems[$key]);
            }
        }
        if ($payer) {
            foreach ($paySystems as $key => &$paySystem) {
                if (!$paySystem["PERSON_TYPE_ID"]) continue;
                if (!in_array($payer, $paySystem["PERSON_TYPE_ID"])) unset($paySystems[$key]);
            }
        }
        if ($paySystemsForDelivery) {
            foreach ($paySystems as $key => &$paySystem) {
                if (!in_array($paySystem["ID"], $paySystemsForDelivery)) unset($paySystems[$key]);
            }
        }
        return $paySystems;
    }

    // получение всего списка типов плательщиков с учетом ограничений по плательщикам ограничениями.
    public function GetPersonTypes()
    {
        $types = CSalePersonType::GetList();
        while ($ob = $types->GetNext()) {
            $persons[] = $ob;
        }

        if ($this->arParams["PERSONS"]) {
            foreach ($persons as $key => $person) {
                if (!in_array($person["ID"], $this->arParams["PERSONS"])) unset($persons[$key]);
            }
        }

        return $persons;
    }

    // получение всех полей, распределение по плательщикам происходит на фронте посредством поля PERSON_TYPE_ID
    public function GetFields($payer = null)
    {
        if ($payer) {
            $dbFields = CSaleOrderProps::GetList(
                array("SORT" => "ASC"),
                array(
                    "PERSON_TYPE_ID" => $payer,
                    "ACTIVE" => "Y",
                ));

        } else {
            $dbFields = CSaleOrderProps::GetList(array("SORT" => "ASC"),
                array(
                    "ACTIVE" => "Y",
                ));
        }
        while ($ob = $dbFields->GetNext()) {
            $result[] = $ob;
        }
        return $result;
    }

    // получение корзины для конкретного пользователя
    public function GetBasketItems()
    {
        $arFUser = CSaleUser::GetList(['USER_ID' => $this->GetUserId()]);
        $basketItems = Bitrix\Sale\Basket::loadItemsForFUser($arFUser['ID'], SITE_ID);
        return $basketItems;
    }

    // создание выбанной платежной системы для заказа
    public function SetPaySystem($order, $paymentId)
    {
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem(
            Bitrix\Sale\PaySystem\Manager::getObjectById(
                intval($paymentId)
            )
        );
        $payment->setField("SUM", $order->getPrice());
        $payment->setField("CURRENCY", $order->getCurrency());
    }

    // создание отгрузки для заказа (с установкой выбранной службы доставки)
    public function setBasketShipment($order, $deliveryId, $basketItems)
    {
        $shipmentCollection = $order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem(Bitrix\Sale\Delivery\Services\Manager::getObjectById($deliveryId));

        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        foreach ($basketItems as $basketItem) {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }
    }

    // создание полей, введенных пользователем, для заказа
    public function setOrderProperties($order, $properties)
    {
        foreach ($order->getPropertyCollection() as $prop) {
            $id = $prop->getField("ORDER_PROPS_ID");
            if ($properties[$id]) {
                $prop->setValue($properties[$id]);
            }
        }
    }

    // создание объекта заказа, который будет использоваться в других методах
    // метод поочередно обращается к других методам, которые добавляют к заказу корзину, параметры и т.д.
    public function SetOrder($PersonTypeId, $deliveryId, $paymentId, $properties)
    {
        $order = Bitrix\Sale\Order::create(SITE_ID, $this->GetUserId());
        $basketItems = $this->GetBasketItems();

        if ($PersonTypeId != null) {
            $order->setPersonTypeId($PersonTypeId);
        }
        $order->setBasket($basketItems);
        if ($deliveryId != null) {
            $this->setBasketShipment($order, $deliveryId, $basketItems);
        }
        if ($properties != null) {
            $this->setOrderProperties($order, $properties);
        }
        if ($paymentId != null) {
            $this->SetPaySystem($order, $paymentId);
        }
        $order->save();
    }

    // вывод всех доставок, платежных систем, плательщиков и полей для ввода из админки в arResult
    public function SetArResult()
    {
        $this->arResult["PAYSYSTEMS"] = $this->GetPaySystems();
        $this->arResult["DELIVERIES"] = $this->GetDeliveries();
        $this->arResult["PERSONTYPE"] = $this->GetPersonTypes();
        $this->arResult["FIELDS"] = $this->GetFields();
    }

    // Изменение порядка вывода доставки и оплаты, в зависимости от настроек компонента
    public function saleOrder()
    {
        if ($this->arParams["ORDER"] == "DELIVERY") {
            $this->arResult["ORDER"]["FIRST"] = $this->arResult["DELIVERIES"];
            $this->arResult["ORDER"]["SECOND"] = $this->arResult["PAYSYSTEMS"];
        } else {
            $this->arResult["ORDER"]["FIRST"] = $this->arResult["PAYSYSTEMS"];
            $this->arResult["ORDER"]["SECOND"] = $this->arResult["DELIVERIES"];
        }
    }

    //функция инициализации компонента. при получение пост параметра MAKE_ORDER создает заказ.
    // параметр передается в ajax запросе при оформлении заказа
    public function executeComponent()
    {
        $this->_checkModules();
        if ($_POST["MAKE_ORDER"] == "Y") {
            foreach ($_POST as $key => $data) {
                if ($key != "PERSONTYPEID" && $key != "DELIVERYID" && $key != "PAYMENTID") {
                    $properties[$key] = $data;
                }
            }
            $this->SetOrder($_POST["PERSONTYPEID"], $_POST["DELIVERYID"], $_POST["PAYMENTID"], $properties);
        }
        $this->SetArResult();
        $this->saleOrder();
        $this->includeComponentTemplate();
    }
}
