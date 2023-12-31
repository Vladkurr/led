$(document).on("click", ".video_link", function (e) {
  e.preventDefault();
  appAspro.loadCSS([
    `${arAsproOptions["SITE_TEMPLATE_PATH"]}/css/jquery.fancybox.min.css`,
    `${arAsproOptions["SITE_TEMPLATE_PATH"]}/css/fancybox-gallery.min.css`,
  ]);
  appAspro.loadScript(`${arAsproOptions["SITE_TEMPLATE_PATH"]}/js/jquery.fancybox.min.js`, () => {
    $(this).fancybox({
      type: "iframe",
      maxWidth: 800,
      maxHeight: 600,
      fitToView: false,
      width: "70%",
      height: "70%",
      autoSize: false,
      closeClick: false,
      opacity: true,
      tpl: {
        closeBtn:
          '<span title="' +
          BX.message("FANCY_CLOSE") +
          '" class="fancybox-item fancybox-close inline svg"><svg class="svg svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"></path></svg></span>',
        next:
          '<a title="' +
          BX.message("FANCY_NEXT") +
          '" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
        prev:
          '<a title="' +
          BX.message("FANCY_PREV") +
          '" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>',
      },
    });
    if (!$(this).hasClass("initied")) {
      $(this).addClass("initied");
      $(this).click();
    }
  });
});
