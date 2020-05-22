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
            logoutUrl: null,
            resetUrl: null
        },

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // set configuration
            me.configuration.logoutUrl = ostConsultantConfiguration.logoutUrl;
            me.configuration.resetUrl = ostConsultantConfiguration.resetUrl;

            // dashboard buttons
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="home"]' ), 'click', $.proxy( me.onHomeClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="account"]' ), 'click', $.proxy( me.onAccountClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="cart"]' ), 'click', $.proxy( me.onCartClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="qr"]' ), 'click', $.proxy( me.onQrClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="search"]' ), 'click', $.proxy( me.onSearchClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="logout"]' ), 'click', $.proxy( me.onLogoutClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="calculator"]' ), 'click', $.proxy( me.onCalculatorClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="calendar"]' ), 'click', $.proxy( me.onCalendarClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="mailer"]' ), 'click', $.proxy( me.onMailerClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="reset"]' ), 'click', $.proxy( me.onResetClick, me ) );

            // optional selectors for emotion elements
            me._on( me.$el.find( 'div.ost-consultant--dashboard--home' ), 'click', $.proxy( me.onHomeClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--account' ), 'click', $.proxy( me.onAccountClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--cart' ), 'click', $.proxy( me.onCartClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--qr' ), 'click', $.proxy( me.onQrClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--search' ), 'click', $.proxy( me.onSearchClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--logout' ), 'click', $.proxy( me.onLogoutClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--calculator' ), 'click', $.proxy( me.onCalculatorClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--calendar' ), 'click', $.proxy( me.onCalendarClick, me ) );
            me._on( me.$el.find( 'div.ost-consultant--dashboard--reset' ), 'click', $.proxy( me.onResetClick, me ) );
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
        onCalculatorClick: function ( event )
        {
            // open calculator
            $.ostFoundationCalculator.open( "Taschenrechner", {} );
        },

        // ...
        onCalendarClick: function ( event )
        {
            // open calculator
            $.ostFoundationCalendar.open( "Kalender", {} );
        },

        // ...
        onMailerClick: function ( event )
        {
            // open calculator
            $.ostConsultantMailer.open( "Mailer", {} );
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

        // ...
        onResetClick: function ( event )
        {
            // get this
            var me = this;

            // do logout
            $.ostFoundationJson.get(
                {
                    url: me.configuration.resetUrl,
                    method: "post"
                },
                function( response ) {
                    $.ostFoundationLoadingIndicator.open();
                    location.reload();
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
