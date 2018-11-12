
;(function ($) {

    // use strict mode
    "use strict";








    // create plugin
    $.plugin( "ostConsultantDashboard", {

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // admin delete
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="home"]' ), 'click', $.proxy( me.onHomeClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="account"]' ), 'click', $.proxy( me.onAccountClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="cart"]' ), 'click', $.proxy( me.onCartClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="qr"]' ), 'click', $.proxy( me.onQrClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="search"]' ), 'click', $.proxy( me.onSearchClick, me ) );
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="logout"]' ), 'click', $.proxy( me.onLogoutClick, me ) );
        },




        // ...
        onHomeClick: function ( event )
        {
            $.ostFoundationLoadingIndicator.open();
            window.location.href = "/";
        },




        // ...
        onAccountClick: function ( event )
        {
            $.ostFoundationLoadingIndicator.open();
            window.location.href = "/account";
        },




        // ...
        onCartClick: function ( event )
        {
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

            $.ostFoundationJson.get(
                {
                    url: "http://inhouse-ost-5501/OstConsultant/logout",
                    method: "post"
                },
                function( response ) {

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








    $( "body.is--ctl-ostconsultant.is--act-dashboard" ).ostConsultantDashboard();





})(jQuery);



