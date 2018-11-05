
;(function ($) {

    // use strict mode
    "use strict";






    // detail plugin
    $.plugin( "ostConsultant", {
    });



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





    // create plugin
    $.plugin( "ostConsultantMenu", {

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // admin delete
            me._on( me.$el, 'click', $.proxy( me.onBadgeClick, me ) );
        },


        // ...
        onBadgeClick: function ( event )
        {


            $.ostFoundationAlert.open(
                '<a href="/account">Kundenkonto</a><br /><a href="/checkout/cart">Warenkorb</a>',
                {
                    valign: false
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










    // create plugin
    $.plugin( "ostConsultantErpCustomerSearch", {

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // admin delete
            me._on( me.$el.find( "button" ), 'click', $.proxy( me.onSearchClick, me ) );
        },





        // ...
        onSearchClick: function ( event )
        {
            // ...
            var me = this;

            var input = me.$el.find( "input" ).val();


            $.ostFoundationAjax.get(
                {
                    url: "http://inhouse-ost-5501/OstConsultant/ErpCustomerSearch",
                    params: { search: input }
                },
                function( response ) {


                    me.$el.find( ".search-result-container" ).html( response );


                    me.$el.find( ".search-result-container .customer button" ).on( "click", function() {

                        var $button = $( this );
                        var $customer = $button.closest( ".customer" );


                        var $form = $( "body form.register--form" );




                        $form.find( "select#register_personal_customer_type" ).val( "private" );

                        $form.find( "select#salutation" ).val( $customer.data( "salutation" ) );



                        var inputs = [ "firstname", "lastname", "phone", "street", "zipcode", "city" ];

                        for ( var key in inputs )
                            $form.find( "input#" + inputs[key] ).val( $customer.data( inputs[key] ) );




                    })

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
    $( "body div.ost-consultant--badge" ).ostConsultantMenu();
    $( "body div.ost-consultant--erp-customer-search" ).ostConsultantErpCustomerSearch();










})(jQuery);



