
;(function ($) {

    // use strict mode
    "use strict";




    // create plugin
    $.plugin( "ostConsultantLogin", {

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // admin delete
            me._on( me.$el, 'click', $.proxy( me.onLoginClick, me ) );
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
                            url: "http://inhouse-ost-5501/OstConsultant/login",
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



