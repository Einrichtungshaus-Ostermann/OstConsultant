
;(function ($) {

    // use strict mode
    "use strict";







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


                        var $form = $( "body form.ost-consultant--register--form" );




                        $form.find( "select#register_personal_customer_type" ).val( "private" );

                        $form.find( "select#salutation" ).val( $customer.data( "salutation" ) );



                        var inputs = [ "firstname", "lastname", "phone", "street", "zipcode", "city" ];

                        for ( var key in inputs )
                            $form.find( "input#" + inputs[key] ).val( $customer.data( inputs[key] ) );




                        if ( $customer.data( "country" ) == "D" )
                            $form.find( "select#country" ).val( "2" );



                        $( "body form.panel.ost-consultant--register--form" ).show();
                        $( "body button.ost-consultant--display-registration" ).hide();

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












    $( "body div.ost-consultant--erp-customer-search" ).ostConsultantErpCustomerSearch();




    $( "body button.ost-consultant--display-registration" ).on( "click", function() {
        $( "body form.panel.ost-consultant--register--form" ).show();
        $( "body button.ost-consultant--display-registration" ).hide();
    });











})(jQuery);



