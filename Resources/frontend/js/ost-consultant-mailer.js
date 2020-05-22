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

    // ...
    $.ostConsultantMailer = {

        // selectors
        selectors: {
            container: 'div.ost-consultant--mailer',
        },

        // more options...
        options: {
        },

        // default options
        defaults: {
        },

        // ...
        buttons: [
            {
                icon: 'icon--vcard',
                name: 'Kontakt',
                controllers: [],
                validate: function() { return true; }
            },
            {
                icon: 'icon--heart',
                name: 'Merkzettel',
                controllers: ['always--disabled'],
                validate: function() { return false; }
            },
            {
                icon: 'icon--basket',
                name: 'Warenkorb',
                controllers: [],
                validate: function() { return parseInt($('body').find('nav.shop--navigation li.navigation--entry.entry--cart span.cart--quantity').html()) > 0 }
            },
            {
                icon: 'icon--info',
                name: 'Produkt Info',
                controllers: ['detail'],
                validate: function() { return ($('body').hasClass('is--ctl-detail')); }
            },
            {
                icon: 'icon--map',
                name: 'Typenplan',
                controllers: ['detail'],
                validate: function() { return ($('body').hasClass('is--ctl-detail')); }
            },
            {
                icon: 'icon--tools',
                name: 'Montage',
                controllers: ['detail'],
                validate: function() { return ($('body').hasClass('is--ctl-detail')); }
            },
        ],

        // ...
        template: '<div class="input--container"><input placeholder="Empfänger Email..." type="text"></div><div class="option--container">#options#</div><div class="action--container"><button>Email senden</button></div>',

        // ...
        open: function( title, options )
        {
            // get this
            var me = this;

            // set options
            me.options = $.extend( {}, me.defaults, ( ( typeof options == "undefined" ) ? {} : options ) );

            // open a modal with our template
            $.modal.open( me._getContent(), {
                title:           title,
                //sizing:          "fixed",
                width:           "60%",
                //height:          "80%",
                animationSpeed:  0,
                keyboardClosing: false,
                additionalClass: "ost-consultant--mailer",

                sizing: 'content',

                onClose:         function() { me._onCloseModal(); }
            });

            // set elements
            me._bindSelectors();

            // bind events
            me._bindEvents();


        },

        // ...
        _bindSelectors: function()
        {
            // get this
            var me = this;

            // set elements
            me.$body = $( "body" );
            me.$el   = me.$body.find( me.selectors.container );

            console.log(me.$el);
        },

        // ...
        _bindEvents: function()
        {
            // get this
            var me = this;


            me.$el.find('.option--container div.btn.is--selectable').on( "click", function() { me._onOptionButtonClick( $( this ) ); } );


        },


        // ...
        _getContent: function()
        {
            // get this
            var me = this;



            var options = '';

            $.each( me.buttons, function( index, button ) {


                var isDisabled = false;


                /*
                if (button.controllers.length > 0) {

                    var isDisabled = true;

                    $.each(button.controllers, function(index, controller) {
                        if ($('body').hasClass('is--ctl-' + controller)) {
                            isDisabled = false;
                        }
                    });

                }
                */

                var isDisabled = (button.validate.call() == false);


                var cls = '' + ((isDisabled === true) ? ' is--disabled' : ' is--selectable');






                options = options + '<div class="btn is--secondary' + cls + '"><i class="' + button.icon + '"></i>' + button.name + '</div>';


            });


            return me.template.replace('#options#', options);


        },



        // ...
        _onOptionButtonClick: function ( $button )
        {
            // get this
            var me = this;

            console.log('clicked');


            $button.toggleClass('is--primary');
            $button.toggleClass('is--secondary');

        },



        // ...
        _onCloseModal: function()
        {
        }

    };

    // call our plugin
    $('body .is--consultant-mailer').on('click', function(event){
        $.ostConsultantMailer.open('Mailer', {});
    });

})(jQuery);
