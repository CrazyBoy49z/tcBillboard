tcBillboard.panel.Orders = function (config) {
    config = config || {};

    Ext.apply(config, {
        cls: 'container',
        items: [{
            html: '<h2>' + _('tcbillboard') + ' :: ' + _('tcbillboard_order_management') + '</h2>',
            cls: 'modx-page-header',
        },{
            xtype: 'modx-tabs',
            id: 'tcbillboard-orders-tabs',
            stateful: true,
            stateId: 'tcbillboard-orders-tabs',
            stateEvents: ['tabchange'],
            getState: function () {
                return {
                    activeTab: this.items.indexOf(this.getActiveTab())
                };
            },
            deferredRender: false,
            items: [{
                title: _('tcbillboard_orders'),
                layout: 'anchor',
                items: [{
                    xtype: 'tcbillboard-form-orders',
                    id: 'tcbillboard-form-orders'
                },{
                    xtype: 'tcbillboard-grid-orders',
                    id: 'tcbillboard-grid-orders'
                }]
            },{
                title: _('tcbillboard_invoice'),
                layout: 'anchor',
                items: [{
                    html: _('tcbillboard_invoice_msg'),
                    cls: 'panel-desc'
                },{
                    xtype: 'tcbillboard-form-invoice',
                    id: 'tcbillboard-form-invoice'
                },{
                    xtype: 'tcbillboard-grid-invoice',
                    id: 'tcbillboard-grid-invoice'
                }]
            },{
                title: _('tcbillboard_warning'),
                layout: 'anchor',
                items: [{
                    html: _('tcbillboard_warning_msg'),
                    cls: 'panel-desc'
                },{
                    xtype: 'tcbillboard-form-warning',
                    id: 'tcbillboard-form-warning'
                },{
                    xtype: 'tcbillboard-grid-warning',
                    id: 'tcbillboard-grid-warning'
                }]
            },{
                title: _('tcbillboard_import_csv'),
                layout: 'anchor',
                items: [{
                    html: _('tcbillboard_import_csv_msg'),
                    cls: 'panel-desc'
                },{
                    xtype: 'tcbillboard-form-import-csv',
                    id: 'tcbillboard-form-import-csv'
                }]
            }]
        }]
    });
    tcBillboard.panel.Orders.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.panel.Orders, MODx.Panel);
Ext.reg('tcbillboard-panel-orders', tcBillboard.panel.Orders);