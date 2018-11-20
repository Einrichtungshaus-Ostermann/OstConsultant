
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
    $.plugin( "ostConsultantDashboard", {

        // our configration
        configuration: {
            logoutUrl: null
        },

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // set configuration
            me.configuration.logoutUrl = ostConsultantConfiguration.logoutUrl;

            // dashboard buttons
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="home"]' ), 'click', $.proxy( me.onHomeClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="account"]' ), 'click', $.proxy( me.onAccountClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="cart"]' ), 'click', $.proxy( me.onCartClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="qr"]' ), 'click', $.proxy( me.onQrClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="search"]' ), 'click', $.proxy( me.onSearchClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="logout"]' ), 'click', $.proxy( me.onLogoutClick, me ) );

            // optional selectors for emotion elements
            me._on( me.$el.find( 'div.ost-consultant--dashboard--home' ), 'click', $.proxy( me.onHomeClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--account' ), 'click', $.proxy( me.onAccountClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--cart' ), 'click', $.proxy( me.onCartClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--qr' ), 'click', $.proxy( me.onQrClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--search' ), 'click', $.proxy( me.onSearchClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--logout' ), 'click', $.proxy( me.onLogoutClick, me ) );
        },

        // ...
        onHomeClick: function ( event )
        {
            // go to home
            $.ostFoundationLoadingIndicator.open();
            window.location.href = "/";
        },

        // ...
        onAccountClick: function ( event )
        {
            // go to account
            $.ostFoundationLoadingIndicator.open();
            window.location.href = "/account";
        },

        // ...
        onCartClick: function ( event )
        {
            // go to cart
            $.ostFoundationLoadingIndicator.open();
            window.location.href = "/checkout/cart";
        },

        // ...
        onQrClick: function ( event )
        {
        },

        // ...
        onSearchClick: function ( event )
        {
            // get this
            var me = this;

            // open number input
            $.ostFoundationNumberInput.open(
                "Artikelsuche",
                {},
                function( number ) {
                    $.ostFoundationLoadingIndicator.open();
                    window.location.href = "/search?sSearch=" + number.toString();
                }
            );
        },

        // ...
        onLogoutClick: function ( event )
        {
            // get this
            var me = this;

            // do logout
            $.ostFoundationJson.get(
                {
                    url: me.configuration.logoutUrl,
                    method: "post"
                },
                function( response ) {

                    // reload current page
                    $.ostFoundationLoadingIndicator.open();
                    window.location.href = "/";
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
    $( "body" ).ostConsultantDashboard();

    // subscribe to emotion load to call dashboard plugin on emotion
    $.subscribe('plugin/swEmotionLoader/onLoadEmotionFinished', function() {
        $( "body div.emotion--wrapper" ).ostConsultantDashboard();
    })

})(jQuery);
