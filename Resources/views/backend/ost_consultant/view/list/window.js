//

Ext.define('Shopware.apps.OstConsultant.view.list.Window', {
    extend: 'Shopware.window.Listing',
    alias: 'widget.discount-list-window',
    height: 450,
    title : 'Filialen',

    configure: function() {
        return {
            listingGrid: 'Shopware.apps.OstConsultant.view.list.Discount',
            listingStore: 'Shopware.apps.OstConsultant.store.Discounts'
        };
    }
});