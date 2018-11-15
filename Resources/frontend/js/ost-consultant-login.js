
;(function ($) {

    // use strict mode
    "use strict";




    // create plugin
    $.plugin( "ostConsultantLogin", {



        configuration: {
            loginUrl: null
        },



        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            me.configuration.loginUrl = ostConsultantConfiguration.loginUrl;

            // admin delete
            me._on( me.$el, 'dblclick', $.proxy( me.onLoginClick, me ) );
        },



        // ...
        onLoginClick: function ( event )
        {
            // get this
            var me = this;

            // open number input
            $.ostFoundationNumberInput.open(
                "Anmeldung als Verkäufer",
                {},
                function( number ) {
                    // try to login
                    $.ostFoundationJson.get(
                        {
                            url: me.configuration.loginUrl,
                            method: "post",
                            params: { number: number }
                        },
                        function( response ) {

                            // login not successfull?
                            if ( response.success == false )
                                // show error
                                return $.ostFoundationAlert.open( "Die Verkäufernummer ist ungültig.", {
                                    callback: function() {
                                        me.onLoginClick( event );
                                    }
                                });

                            // ...
                            $.ostFoundationLoadingIndicator.open();

                            // reload current page
                            location.reload( true );
                        }
                    );
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
    $( "body .ost-consultant--login" ).ostConsultantLogin();











})(jQuery);



