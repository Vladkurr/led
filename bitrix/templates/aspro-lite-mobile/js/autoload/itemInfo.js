appAspro.itemInfo = {};

appAspro.itemInfo.actual = () => {
  const data = new FormData();
  data.append("sessid", BX.bitrix_sessid());

  fetch(`${arAsproOptions["SITE_TEMPLATE_PATH_MOBILE"]}/ajax/itemInfo.php`, {
    method: "POST",
    body: data,
  })
    .then(data => data.json())
    .then(data => {
      if (data.STATUS !== "OK") throw new Error(data.ERROR);
      arAsproCounters = data.INFO;

      var eventdata = { action: "ajaxContentLoaded" };
      BX.onCustomEvent("onCompleteAction", [eventdata]);
    })
    .catch(err => console.error(err));
};

BX.ready(() => {
  appAspro.itemInfo.actual();
});
