<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Подтверждение номера");
$_SESSION["SENDED"] = true;
?>
    <div class="registraion-page pk-page">
        <div class="form form--send-sms" style="max-width: 484px;padding: 0; margin: auto;">
            <div class="form-header">
                <div class="text">
                    <div class="title switcher-title font_24 color_222">Введите код из СМС</div>
                    <div class="form_desc font_16">Мы отправили код подтверждения на
                        номер <?= $_POST['PHONE_NUMBER'] ?></div>
                </div>
            </div>
            <form id="registraion-page-form" method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform">
                <input type="hidden" name="backurl" value="<?= $arResult['BACKURL'] ?>"/>

                <input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult['SIGNED_DATA']) ?>"/>

                <div class="form_body">
                    <div class="form-group fill-animate phone_code">

                        <label class="font_14" for="input_SMS_CODE"><?= GetMessage('REGISTER_FIELD_SMS_CODE') ?> <span
                                    class="required-star">*</span></label>
                        <div class="input">
                            <input id="input_SMS_CODE" class="form-control required" size="30" type="text"
                                   name="SMS_CODE" value="<?= htmlspecialcharsbx($arResult['SMS_CODE']) ?>"
                                   autocomplete="off" <?= $class ?> />
                        </div>
                    </div>
                </div>
                <div class="form-footer hidden">
                    <button class="btn btn-default btn-lg btn-wide" type="submit" name="code_submit_button"
                            value="Y"><?= GetMessage('main_register_sms_send') ?></button>
                </div>
            </form>
            <div id="bx_register_error" style="display:none"><? ShowError('error') ?></div>
            <div id="bx_register_resend"></div>
        </div>
        <script>
            console.log(123)
            $(document).ready(function () {
                var params = new URLSearchParams();
                params.set('PHONE', "<?= $_GET["PHONE"] ?>");

                url = "ajax/checkPhone.php"
                let result = await fetch(url, {
                    method: 'POST',
                    body: params,
                }).then(response => {
                    return response.text()
                }).then(data => {
                    return data;
                })
                console.log(result)
            }
        </script>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>