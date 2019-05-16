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
    $.ostConsultantDiscountSelection = {

        // selectors
        selectors: {
            container:        'div.ost-consultant--discount-selection',
            abortButton:      'button[data-abort="true"]',
            submitButton:     'button[data-submit="true"]'
        },

        // ...
        configuration: {
            getDiscountsUrl: null
        },

        // more options...
        options: {
        },

        // default options
        defaults: {
            callbackSubmit: function( discount ) {},
            callbackAbort: function() {},
            target: "P"
        },

        // ...
        template: '<div class="discount-container">was geht</div><div class="button-container"><button class="is--button is--red" data-abort="true">Abbrechen</button><button class="is--button is--green" data-submit="true">Bestätigen</button></div>',
        discount: '<div class="discount block-group" data-json=#json#><div class="number block">#number#</div><div class="name block">#name#</div><div class="value block">#value#</div></div>',

        // body
        $body: null,

        // the element container
        $el: null,

        // ...
        open: function( title, options )
        {
            // get this
            var me = this;

            // set options
            me.options = $.extend( {}, me.defaults, ( ( typeof options == "undefined" ) ? {} : options ) );

            // set configuration
            me.configuration.getDiscountsUrl = ostConsultantConfiguration.getDiscountsUrl;

            // get discounts first
            $.ostFoundationJson.get(
                {
                    url: me.configuration.getDiscountsUrl,
                    params: { target: me.options.target },
                },
                function( response )
                {
                    // open a modal with our template
                    $.modal.open( me.template, {
                        title:           title,
                        sizing:          "fixed",
                        width:           "60%",
                        height:          "80%",
                        animationSpeed:  0,
                        keyboardClosing: false,
                        additionalClass: "ost-consultant--discount-selection",
                        onClose:         function() { me._onCloseModal(); }
                    });

                    // set elements
                    me.$body = $( "body" );
                    me.$el   = me.$body.find( me.selectors.container );

                    // add discounts
                    me._addDiscounts(response.discounts);

                    // set elements
                    me._bindSelectors();

                    // bind events
                    me._bindEvents();
                }
            );
        },

        // ...
        _addDiscounts: function(discounts)
        {
            // get this
            var me = this;

            // final html for the container
            var html = "";

            // loop every discount
            for ( var i in discounts )
            {
                // get it
                var discount = discounts[i];

                // replace default values
                var tpl = me.discount;
                tpl = tpl.replace( "#number#", discount.number );
                tpl = tpl.replace( "#name#", discount.name );

                // get the value
                var value = parseFloat(discount.value);

                // replace by value
                if ( value > 0 ) {
                    tpl = tpl.replace( "#value#", ( discount.type === "A" ) ? discount.value.replace(".",",") + " EUR" : discount.value + "%" );
                }
                else  {
                    tpl = tpl.replace( "#value#", "" );
                }

                // set json
                tpl = tpl.replace( "#json#", "'" + JSON.stringify(discount) + "'" );

                // and add to template
                html = html + tpl;
            }

            // set in cintainer
            me.$el.find( '.discount-container').html(html);
        },

        // ...
        _bindSelectors: function()
        {
            // get this
            var me = this;

            // set elements
            me.$body = $( "body" );
            me.$el   = me.$body.find( me.selectors.container );
        },

        // ...
        _bindEvents: function()
        {
            // get this
            var me = this;

            // bind everything
            me.$el.find(".discount").on( "click", function() { me._onDiscountClick( $( this ) ); } );
            me.$el.find(me.selectors.abortButton).on( "click", function() { me._onAbortClick( $( this ) ); } );
            me.$el.find(me.selectors.submitButton).on( "click", function() { me._onSubmitClick( $( this ) ); } );
        },

        // ...
        _onSubmitClick: function ( button ) {
            // get this
            var me = this;

            // no discount selected?
            if ( me.$el.find(".discount.is--selected").length === 0 )
                // dont do anything
                return;

            // get discount data
            var discount = me.$el.find(".discount.is--selected");
            var json = discount.data("json");

            // close current modal
            $.modal.close();

            // call the callback
            me.options.callbackSubmit.call(
                this,
                json
            );
        },

        // ...
        _onAbortClick: function ( button ) {
            // get this
            var me = this;

            // jsut close modal
            $.modal.close();
        },
        
        // ...
        _onDiscountClick: function ( button ) {
            // get this
            var me = this;

            // is this one selected?
            if ( button.hasClass("is--selected"))
            {
                // remove selected
                button.removeClass("is--selected");
                return;
            }

            // add selected for current one
            me.$el.find(".discount.is--selected").removeClass("is--selected");
            button.addClass("is--selected");
        },

        // ...
        _onCloseModal: function()
        {
        }
    };

    // create plugin
    $.plugin( "ostConsultantDiscount", {

        opts: {
            target: "P"
        },

        // ...
        configuration: {
            addDiscountUrl: null,
            cartUrl: null
        },

        // on initialization
        init: function ()
        {
            // get this
            var me = this;

            // set configuration
            me.configuration.addDiscountUrl = ostConsultantConfiguration.addDiscountUrl;
            me.configuration.cartUrl = ostConsultantConfiguration.cartUrl;

            // add bindings
            me._on( me.$el, 'click', $.proxy( me.onButtonClick, me ) );
        },

        // ...
        onButtonClick: function ( event )
        {
            // get this
            var me = this;

            // open discount selection
            $.ostConsultantDiscountSelection.open(
                "Nachlass wählen",
                {
                    target: me.opts.target,
                    callbackSubmit: function( discount ) {me._selectValue(discount);}
                }
            );
        },

        // ...
        _selectValue: function(discount)
        {
            // get this
            var me = this;

            // is the value fixed?
            if ( discount.fixed === "1" )
            {
                // directly add discount
                me._addDiscount(discount, parseFloat(discount.value));
                return;
            }

            // set title depending on type
            var title = ( discount.type === "P" ) ? "Nachlass in Prozent angeben" : "Nachlass in EUR angeben";

            // open number input to ask for value
            $.ostFoundationNumberInput.open(
                title,
                {
                    castToInteger: false,
                    hasDecimals: true
                },
                function( number )
                {
                    number = number.replace(",",".");
                    number = parseFloat(number);
                    me._addDiscount(discount, number);
                },
                function() {},
                function( number ) { return true; }
            );
        },

        // ...
        _addDiscount: function(discount, value)
        {
            // get this
            var me = this;

            // save discount
            $.ostFoundationJson.get(
                {
                    url: me.configuration.addDiscountUrl,
                    params: { number: discount.number, value: value, basketId: me.$el.data("id") },
                },
                function( response )
                {
                    // ...
                    if (response.success === false ) {
                        $.ostFoundationAlert.open(response.error, {});
                        return;
                    }

                    // redirect to cart
                    $.ostFoundationLoadingIndicator.open();
                    window.location.href = me.configuration.cartUrl;
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
    $( "body.is--ctl-checkout.is--act-cart button.ost-consultant--discount-button" ).ostConsultantDiscount({target: "P"});
    $( "body.is--ctl-checkout.is--act-cart button.ost-consultant--head-discount-button" ).ostConsultantDiscount({target: "K"});

})(jQuery);
