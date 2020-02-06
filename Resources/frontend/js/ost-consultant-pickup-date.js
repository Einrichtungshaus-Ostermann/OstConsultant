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
    $.plugin( "ostConsultantPickupDate", {

        // configuration
        configuration: {
        },

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // ...
            me._on( me.$el, 'click', $.proxy( me.onDateSelection, me ) );
        },

        // ...
        onDateSelection: function ( event )
        {
            // get this
            var me = this;

            // open calendar
            $.ostFoundationCalendar.open(
                'Kalender',
                {
                    selectable: true,
                    callback: function(year, month, day)
                    {
                        me.$el.html(day.toString() + '.' + month.toString() + '.' + year.toString());
                        $( "body" ).find('input#ost-consultant--pickup-date').val(day.toString() + '.' + month.toString() + '.' + year.toString());
                    }
                }
            );
        },

        // on destroy
        destroy: function()
        {
            // get this
            var me = this;

            // call the parent
            me._destroy();
        }
    });

    // call our plugin
    $( 'body.is--ctl-checkout.is--act-confirm div[data-ost-consultant-pickup-date="true"]' ).ostConsultantPickupDate();

})(jQuery);
