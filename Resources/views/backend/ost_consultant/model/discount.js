
Ext.define('Shopware.apps.OstConsultant.model.Discount', {
    extend: 'Shopware.data.Model',

    configure: function() {
        return {
            controller: 'OstConsultant',
            detail: 'Shopware.apps.OstConsultant.view.detail.Discount'
        };
    },

    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'company', type: 'string' },
        { name: 'number', type: 'string' },
        { name: 'type', type: 'string' },
        { name: 'target', type: 'string' },
        { name: 'name', type: 'string' },
        { name: 'value', type: 'string' },
        { name: 'fixed', type: 'boolean' }
    ],

});
