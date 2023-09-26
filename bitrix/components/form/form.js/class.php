<?php
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class Form extends CBitrixComponent {
    private $_request;
    public function executeComponent() {
        if($this->request->getPost("TOKEN") == $this->arParams["TOKEN"]){
            if($this->arParams["MAIL_TO"] != null){
                mail($this->arParams["MAIL_TO"], "form", $_POST);
            }
            if($this->arParams["MAIL_EVENT"] != null){
                foreach ($this->arParams["MAIL_EVENT"] as $event){
                    CEvent::Send($event, SITE_ID, $_POST);
                }
            }
        }
        $this->_request = Application::getInstance()->getContext()->getRequest();
        $this->includeComponentTemplate();
    }
}