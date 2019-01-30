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
    $.plugin( "ostConsultantErpCustomerSearch", {

        // our configuration
        configuration: {
            erpCustomerSearchUrl: null
        },

        // error message template
        error: '<div class="alert is--error is--rounded"><div class="alert--icon"><i class="icon--element icon--warning"></i></div><div class="alert--content">#message#</div></div>',

        // minimum string length for the search
        minLength: 3,

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // set configuration
            me.configuration.erpCustomerSearchUrl = ostConsultantConfiguration.erpCustomerSearchUrl;

            // on search click
            me._on( me.$el.find( "button" ), 'click', $.proxy( me.onSearchClick, me ) );

            // enter click listener
            me.$el.find( 'input[type="text"]' ).on('keyup', function (e) {
                if (e.keyCode == 13) {
                    me.onSearchClick( null );
                }
            });
        },

        // ...
        onSearchClick: function ( event )
        {
            // ...
            var me = this;

            // get the input
            var input = me.$el.find( "input" ).val().trim();

            // we have a minimum lenght
            if ( input.length < me.minLength )
            {
                // get error and set it
                var error = me.error.replace( "#message#", "Bitte geben Sie mindestens " + me.minLength.toString() + " Zeichen ein." );
                me.$el.find( ".search-result-container" ).html( error );
                return;
            }

            // search
            $.ostFoundationAjax.get(
                {
                    url: me.configuration.erpCustomerSearchUrl,
                    params: { search: input }
                },
                function( response ) {

                    // set the search result
                    me.$el.find( ".search-result-container" ).html( response );

                    // bind every button from the result
                    me.$el.find( ".search-result-container .customer button" ).on( "click", function() {

                        // get parameters
                        var $button = $( this );
                        var $customer = $button.closest( ".customer" );
                        var $form = $( "body form.ost-consultant--register--form" );

                        // special input
                        $form.find( "select#register_personal_customer_type" ).val( "private" );
                        $form.find( "select#salutation" ).val( $customer.data( "salutation" ) );

                        // default text input
                        var inputs = [ "firstname", "lastname", "phone", "street", "zipcode", "city" ];

                        // loop and set them
                        for ( var key in inputs )
                            $form.find( "input#" + inputs[key] ).val( $customer.data( inputs[key] ) );

                        // set country
                        //if ( $customer.data( "country" ) == "D" )
                        //    $form.find( "select#country" ).val( "2" );

                        // email address
                        $form.find( "input#register_personal_email" ).val( $customer.data( "email" ) );

                        // always force germany
                        $form.find( "select#country" ).val( "2" );

                        // set html
                        $( "body form.panel.ost-consultant--register--form" ).show();
                        $( "body button.ost-consultant--display-registration" ).hide();

                        // clear result
                        me.$el.find( ".search-result-container" ).html( "" );

                        // remove result and scroll to top
                        $( "body" ).find( ".ost-consultant--erp-customer-search" ).remove();
                        $( "body" ).find( "form.ost-consultant--register--form div.register--content" ).css('margin-top','0');
                        $("html, body").animate({ scrollTop: 0 }, "fast");

                    });
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

    // call plugin
    $( "body div.ost-consultant--erp-customer-search" ).ostConsultantErpCustomerSearch();

    // listener to "display registration" button
    $( "body button.ost-consultant--display-registration" ).on( "click", function() {

        // remove search and show registration
        $( "body form.panel.ost-consultant--register--form" ).show();
        $( "body button.ost-consultant--display-registration" ).hide();

        // remove everything and scroll to top
        $( "body" ).find( ".ost-consultant--erp-customer-search" ).remove();
        $( "body" ).find( "form.ost-consultant--register--form div.register--content" ).css('margin-top','0');
        $("html, body").animate({ scrollTop: 0 }, "fast");
    });

})(jQuery);
