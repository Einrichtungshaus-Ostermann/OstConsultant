
;(function ($) {

    // use strict mode
    "use strict";




    // create plugin
    $.plugin( "ostConsultantLogin", {



        configuration: {
            loginUrl: null,
            logoutUrl: null
        },



        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            me.configuration.loginUrl = ostConsultantConfiguration.loginUrl;
            me.configuration.logoutUrl = ostConsultantConfiguration.logoutUrl;

            // double click on hidden button on every site
            me._on( me.$el.find( ".ost-consultant--login" ), 'dblclick', $.proxy( me.onLoginClick, me ) );

            // login button on plugin dashboard
            me._on( me.$el.find( 'button[data-ost-consultant-dashboard="login"]' ), 'click', $.proxy( me.onLoginClick, me ) );

            // login button on emotion dashboard
            me._on( me.$el.find( "div.ost-consultant--dashboard--login" ), 'click', $.proxy( me.onLoginClick, me ) );
        },



        // ...
        onLoginClick: function ( event )
        {
            // get this
            var me = this;



            // are we already logged in?!
            if ( $( "body" ).hasClass( "is--consultant" ) )
            {

                $.ostFoundationJson.get(
                    {
                        url: me.configuration.logoutUrl,
                        method: "post"
                    },
                    function( response ) {

                        $.ostFoundationLoadingIndicator.open();
                        location.reload( true );

                    }
                );

                return;

            }


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
    $( "body" ).ostConsultantLogin();




    $.subscribe('plugin/swEmotionLoader/onLoadEmotionFinished', function() {


        $( "body div.emotion--wrapper" ).ostConsultantLogin();
    })








})(jQuery);



