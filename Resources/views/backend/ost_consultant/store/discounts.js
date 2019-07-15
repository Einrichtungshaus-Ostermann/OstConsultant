//

Ext.define('Shopware.apps.OstConsultant.store.Discounts', {
    extend:'Shopware.store.Listing',

    configure: function() {
        return {
            controller: 'OstConsultant'
        };
    },

    model: 'Shopware.apps.OstConsultant.model.Discount'
});