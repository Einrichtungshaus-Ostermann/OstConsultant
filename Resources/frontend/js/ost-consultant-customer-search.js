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
    $.plugin( "ostConsultantCustomerSearch", {

        // our configuration
        configuration: {
            customerSearchUrl: null
        },

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // set configuration
            me.configuration.customerSearchUrl = ostConsultantConfiguration.customerSearchUrl;

            // admin delete
            me._on( me.$el.find( "button" ), 'click', $.proxy( me.onSearchClick, me ) );
        },

        // ...
        onSearchClick: function ( event )
        {
            // ...
            var me = this;

            // get the input
            var input = me.$el.find( "input" ).val();

            // do the search
            $.ostFoundationAjax.get(
                {
                    url: me.configuration.customerSearchUrl,
                    params: { search: input }
                },
                function( response ) {

                    // set response
                    me.$el.find( ".search-result-container" ).html( response );
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
    $( "body div.ost-consultant--customer-search" ).ostConsultantCustomerSearch();

})(jQuery);
