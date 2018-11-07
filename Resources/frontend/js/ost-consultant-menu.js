
;(function ($) {

    // use strict mode
    "use strict";








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








    $( "body div.ost-consultant--badge" ).ostConsultantMenu();





})(jQuery);



