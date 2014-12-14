/**
 * Created by user on 7/18/14.
 */

jQuery(function () {
    jQuery('.c006-activeform-toggle-container')
        .bind("click",
              function () {
                  /* This is not ideal, but it works for now */
                  setTimeout(function () {
                      var $elm = jQuery('#crud-exclude_models').parent().parent();
                      $elm.hide();
                      var $ow = jQuery('#crud-overwrite_models');
                      if ($ow.val() == "1") {
                          $elm.show("fast");
                      }
                      $elm = jQuery('#crud-exclude_controllers').parent().parent();
                      $elm.hide();
                      $ow = jQuery('#crud-overwrite_controllers');
                      if ($ow.val() == "1") {
                          $elm.show("fast");
                      }
                  }, 100);
              })
        .trigger('click');

});


