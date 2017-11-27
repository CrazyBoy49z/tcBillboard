tcBillboard.panel.Chart = function(config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-chart-orders';
    }
    Ext.applyIf(config, {
        layout: 'form',
        items: [{
            html: '<div id="tcbillboard-chart"></div>'
        }],
        // listeners: {
        //     afterlayout: {
        //         fn: function () {
        //             this.setup(config.dataset);
        //         }, scope: this
        //     },
        //     single: true
        // }
    });
    tcBillboard.panel.Chart.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.panel.Chart, MODx.Panel, {
        setup: function(dataset) {

        }
});
Ext.reg('tcbillboard-chart-orders', tcBillboard.panel.Chart);