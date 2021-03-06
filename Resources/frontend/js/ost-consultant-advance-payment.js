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
    $.plugin( "ostConsultantAdvancePayment", {

        // configuration
        configuration: {
            amount: null
        },

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // set configuration
            me.configuration.amount = parseFloat(me.$el.data('amount'));

            // ...
            me._on( me.$el.find( 'button[data-ost-consultant-advance-payment-button="true"]' ), 'click', $.proxy( me.onButtonClick, me ) );
            me._on( me.$el.find( 'input[data-ost-consultant-advance-payment-input="true"]' ), 'click', $.proxy( me.onButtonClick, me ) );
        },

        // ...
        onButtonClick: function ( event )
        {
            // get this
            var me = this;

            // open number input
            $.ostFoundationNumberInput.open(
                "Anzahlung leisten",
                {
                    castToInteger: false,
                    hasDecimals: true,
                    noHeader: true
                },
                function( number ) {

                    // parse to float
                    number = number.replace(",", ".");
                    number = parseFloat( number );

                    // maximum amount
                    if (number > me.configuration.amount) {
                        $.ostFoundationAlert.open('Die Anzahlung darf nicht höher als die Gesamtsumme sein.', { noHeader: true });
                        return;
                    }

                    // as locale currency string
                    number = Number(number).toLocaleString("de-DE", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                    // and set to input and to hidden field
                    me.$el.find( 'input[data-ost-consultant-advance-payment-input="true"]' ).val(number +  " €");
                    $( "body" ).find('input#ost-consultant--advance-payment').val(number);

                },
                function() {},
                function(number) { return true; }
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
    $( "body.is--ctl-checkout.is--act-confirm .ost-consultant--advance-payment--container" ).ostConsultantAdvancePayment();

})(jQuery);
