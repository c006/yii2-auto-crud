/**
 * Created by user on 7/18/14.
 */

jQuery(function () {
    jQuery('#form-crud').on("click", "input[type=checkbox]",
        function () {
            c006_checkboxes();
        });
    function c006_checkboxes() {
        var $cb = jQuery('#crud-exclude_models').parent().parent();
        $cb.hide();
        if (jQuery('#crud-override_models').is(':checked')) {
            $cb.show("fast");
        }
        $cb = jQuery('#crud-exclude_controllers').parent().parent();
        $cb.hide();
        if (jQuery('#crud-override_controllers').is(':checked')) {
            $cb.show("fast");
        }
    }

    c006_checkboxes();
});


