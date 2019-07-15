//

Ext.define('Shopware.apps.OstConsultant.view.list.Discount', {
    extend: 'Shopware.grid.Panel',
    alias:  'widget.discount-listing-grid',
    region: 'center',

    configure: function() {
        return {
            detailWindow: 'Shopware.apps.OstConsultant.view.detail.Window',
            columns: {
                id: { header: 'ID', width: 60 },
                name: { header: 'Name', flex: 1 }
            }
        };
    }
});
