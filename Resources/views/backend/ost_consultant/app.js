
Ext.define('Shopware.apps.OstConsultant', {
    extend: 'Enlight.app.SubApplication',

    name:'Shopware.apps.OstConsultant',

    loadPath: '{url action=load}',
    bulkLoad: true,

    controllers: [ 'Main' ],

    views: [
        'list.Window',
        'list.Discount',

        'detail.Discount',
        'detail.Window'
    ],

    models: [ 'Discount' ],
    stores: [ 'Discounts' ],

    launch: function() {
        return this.getController('Main').mainWindow;
    }
});