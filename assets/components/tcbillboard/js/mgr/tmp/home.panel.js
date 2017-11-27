tcBillboard.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'tcbillboard-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('tcbillboard') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('tcbillboard_items'),
                layout: 'anchor',
                items: [{
                    html: _('tcbillboard_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'tcbillboard-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    tcBillboard.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.panel.Home, MODx.Panel);
Ext.reg('tcbillboard-panel-home', tcBillboard.panel.Home);
