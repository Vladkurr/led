BX.ready(function(){
  appAspro.loadScript([arAsproOptions["SITE_TEMPLATE_PATH"] + "/vendor/jquery.validate.min.js", arAsproOptions["SITE_TEMPLATE_PATH"] + "/js/conditional/validation.min.js"], function(){
    $("form.subscribe-form").validate({
      rules: { EMAIL: { email: true } },
    });
  })
})