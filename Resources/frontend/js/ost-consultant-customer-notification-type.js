/**
 * Einrichtungshaus Ostermann GmbH & Co. KG - Consultant
 *
 * @package   OstConsultant
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

;(function ($) {

    // use strict mode
    "use strict";

    // create plugin
    $.plugin( "ostConsultantCustomerNotificationType", {

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // set current value
            $('body').find('input#ost-consultant--customer-notification-type').val(
                $('body').find('select[data-ost-consultant-customer-notification-type-select="true"] option:selected').val()
            );

            // change listener
            me._on( me.$el.find( 'select[data-ost-consultant-customer-notification-type-select="true"]' ), 'change', $.proxy( me.onChangeClick, me ) );
        },

        // ...
        onChangeClick: function ( event )
        {
            // save selection
            $('body').find('input#ost-consultant--customer-notification-type').val(
                $('body').find('select[data-ost-consultant-customer-notification-type-select="true"] option:selected').val()
            );
        },

        // on destroy
        destroy: function()
        {
            // call the parent
            this._destroy();
        }
    });

    // call our plugin
    $( "body.is--ctl-checkout.is--act-confirm .ost-consultant--customer-notification-type--container" ).ostConsultantCustomerNotificationType();

})(jQuery);
