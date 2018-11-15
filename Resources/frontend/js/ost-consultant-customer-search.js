
;(function ($) {

    // use strict mode
    "use strict";












    // create plugin
    $.plugin( "ostConsultantCustomerSearch", {




        configuration: {
            customerSearchUrl: null
        },




        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            me.configuration.customerSearchUrl = ostConsultantConfiguration.customerSearchUrl;

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
                    url: me.configuration.customerSearchUrl,
                    params: { search: input }
                },
                function( response ) {


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








    $( "body div.ost-consultant--customer-search" ).ostConsultantCustomerSearch();










})(jQuery);



