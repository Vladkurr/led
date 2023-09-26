// selectOffer js
function useOfferSelect() {
    BX.ready(() => {
        if (!("SelectOfferProp" in window)) {
            const $catalogItems = $(".catalog-items");
            if ($catalogItems.length) {
                $catalogItems.iAppear(
                    function (e) {
                        BX.loadScript(
                            [
                                arAsproOptions.SITE_TEMPLATE_PATH + "/js/select_offer.js?v=2",
                                arAsproOptions.SITE_TEMPLATE_PATH + "/js/select_offer_func.js?v=2",
                            ]
                        );
                    },
                    { accX: 0, accY: 100 }
                );
            }
        }
    });
}