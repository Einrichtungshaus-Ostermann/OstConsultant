
;(function ($) {

    // use strict mode
    "use strict";












    // create plugin
    $.plugin( "ostConsultantCustomerSearch", {

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
                    url: "http://inhouse-ost-5501/OstConsultant/CustomerSearch",
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



