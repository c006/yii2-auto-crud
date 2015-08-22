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
    jQuery('label[for=crud-database_tables]')
        .append('<span class="c006-add-all">add all</span>')
        .click(function () {
            var _html = '';
            jQuery('#crud-database_tables')
                .find('option')
                .each(function (item) {
                    _html += ',' + jQuery(this).html();
                });
            jQuery('#crud-tables').val(_html.replace(/\s+/gi, '').replace(/,+/gi, ',').replace(/^,/, ''));
        });
    jQuery('#crud-database_tables')
        .bind('change',
        function () {
            var val = jQuery(this).find('option:selected').text();
            if (val) {
                var $elm = jQuery('#crud-tables');
                var val2 = $elm.val().replace(val + ',', '');
                val = val2 + ',' + val;
                val = val.replace(/\s+/gi, '').replace(/,+/gi, ',').replace(/^,/, '');
                $elm.val(val);
            }
        });
});


