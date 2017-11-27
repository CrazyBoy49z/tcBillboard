tcBillboard.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'tcbillboard-panel-home',
            renderTo: 'tcbillboard-panel-home-div'
        }]
    });
    tcBillboard.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.page.Home, MODx.Component);
Ext.reg('tcbillboard-page-home', tcBillboard.page.Home);