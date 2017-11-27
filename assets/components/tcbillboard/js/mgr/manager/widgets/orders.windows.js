tcBillboard.window.UpdateOrders = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-order-window-update';
    }
    Ext.applyIf(config, {
        title: _('tcbillboard_order_update'),
        width: 900,
        baseParams: {
            action: 'mgr/manager/orders/update'
        }
    });
    tcBillboard.window.UpdateOrders.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.window.UpdateOrders, tcBillboard.window.Default, {
    getFields: function (config) {
        return {
            xtype: 'modx-tabs',
            activeTab: config.activeTab || 0,
            bodyStyle: {background: 'transparent'},
            deferredRender: false,
            autoHeight: true,
            stateful: true,
            stateId: 'tcbillboard-order-window-update',
            stateEvents: ['tabchange'],
            items: this.getTabs(config),
            getState: function () {
                return {activeTab: this.items.indexOf(this.getActiveTab())};
            },
        };
    },

    getTabs: function(config) {
        var tabs = [{
            title: _('tcbillboard_order'),
            hideMode: 'offsets',
            defaults: {msgTarget: 'under', border: false},
            items: this.getOrderFields(config)
        },{
            title: _('tcbillboard_order_details'),
            xtype: 'tcbillboard-order-grid-details',
            order_id: config.record.id
        }];

        return tabs;
    },

    getOrderFields: function(config) {
        return [{
            xtype: 'hidden',
            name: 'id'
        },{
            layout: 'column',
            defaults: {msgTarget: 'under', border: false},
            style: 'padding:15px 5px;text-align:center;border: 1px solid #e0dfdf;',
            items: [{
                columnWidth: .33,
                layout: 'form',
                items: [
                    { xtype: 'displayfield', name: 'num', fieldLabel: _('tcbillboard_invoice'), anchor: '90%' }
                ]
            },{
                columnWidth: .33,
                layout: 'form',
                items: [
                    { xtype: 'displayfield', name: 'createdon', fieldLabel: _('tcbillboard_order_createdon'), anchor: '90%' }
                ]
            },{
                columnWidth: .33,
                layout: 'form',
                items: [
                    { xtype: 'displayfield', name: 'paymentdate', fieldLabel: _('tcbillboard_order_paymentdate'), anchor: '90%' }
                ]
            }]
        },{
            layout: 'column',
            defaults: {msgTarget: 'under', border: false},
            anchor: '100%',
            items: [{
                columnWidth: .48,
                layout: 'form',
                items: [{
                    xtype: 'tcbillboard-combo-status',
                    id: config.id + '-status',
                    name: 'status',
                    fieldLabel: _('tcbillboard_status'),
                    anchor: '100%',
                    order_id: config.record.id
                },{
                    xtype: 'tcbillboard-combo-payment',
                    id: config.id + '-combo-payment',
                    name: 'payment',
                    fieldLabel: _('tcbillboard_payment'),
                    anchor: '100%',
                    payment_id: config.record.payment
                }]
            },{
                columnWidth: .48,
                layout: 'form',
                style: 'padding:15px 5px;text-align:center;',
                items: [{
                    xtype: 'displayfield',
                    name: 'sum',
                    fieldLabel: _('tcbillbord_order_cost'),
                    anchor: '100%',
                    style: 'font-size:2em;'
                }]
            }]
        }]
    },

    getKeys: function () {
        return {
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }
    },
});
Ext.reg('tcbillboard-order-window-update', tcBillboard.window.UpdateOrders);





// tcBillboard.window.UpdateOrders = function (config) {
//     config = config || {};
//     if (!config.id) {
//         config.id = 'tcbillboard-order-window-update';
//     }
//     Ext.applyIf(config, {
//         title: _('tcbillboard_order_update'),
//         width: 900,
//         autoHeight: true,
//         allowDrop: false,
//         record: {},
//         url: tcBillboard.config.connector_url,
//         action: 'mgr/manager/orders/update',
//         fields: this.getFields(config),
//         keys: [{
//             key: Ext.EventObject.ENTER,
//             shift: true, fn: function () {
//                 this.submit()
//             }, scope: this
//         }],
//         keys: this.getKeys(config),
//         listeners: this.getListeners(config)
//     });
//     tcBillboard.window.UpdateOrders.superclass.constructor.call(this, config);
// };
// Ext.extend(tcBillboard.window.UpdateOrders, MODx.Window, {
//
//     getFields: function (config) {
//         return {
//             xtype: 'modx-tabs',
//             activeTab: config.activeTab || 0,
//             bodyStyle: {background: 'transparent'},
//             deferredRender: false,
//             autoHeight: true,
//             stateful: true,
//             stateId: 'tcbillboard-order-window-update',
//             stateEvents: ['tabchange'],
//             getState: function () {
//                 return {activeTab: this.items.indexOf(this.getActiveTab())};
//             },
//             items: [{
//                 title: _('tcbillboard_order'),
//                 layout: 'anchor',
//                 items: [{
//                     xtype: 'hidden',
//                     name: 'id'
//                 },{
//                     xtype: 'fieldset',
//                     layout: 'column',
//                     defaults: {msgTarget: 'under', border: false},
//                     style: 'padding:15px 5px;text-align:center;',
//                     items: [{
//                         columnWidth: .33,
//                         layout: 'form',
//                         items: [
//                             { xtype: 'displayfield', name: 'num', fieldLabel: _('tcbillboard_invoice'), anchor: '90%' },
//                         ]
//                     },{
//                         columnWidth: .33,
//                         layout: 'form',
//                         items: [
//                             { xtype: 'displayfield', name: 'createdon', fieldLabel: _('tcbillboard_order_createdon'), anchor: '90%' },
//                         ]
//                     },{
//                         columnWidth: .33,
//                         layout: 'form',
//                         defaults: {msgTarget: 'under'},
//                         items: [
//                             {
//                                 xtype: 'displayfield',
//                                 name: 'paymentdate',
//                                 fieldLabel: _('tcbillboard_order_paymentdate'),
//                                 anchor: '90%'
//                                 //format: MODx.config['manager_date_format'] || 'Y-m-d', anchor: '90%'
//
//                                 /*xtype: 'xdatetime',
//                                 fieldLabel: _('tcbillboard_order_paymentdate'),
//                                 name: 'paymentdate',
//                                 allowBlank: true,
//                                 dateFormat: MODx.config.manager_date_format,
//                                 timeFormat: MODx.config.manager_time_format,
//                                 startDay: parseInt(MODx.config.manager_week_start),
//                                 dateWidth: 200,
//                                 timeWidth: 120,*/
//                                 //offset_time: MODx.config.server_offset_time
//                             }
//                         ]
//                     }]
//                 },{
//                     layout: 'column',
//                     defaults: {msgTarget: 'under', border: false},
//                     anchor: '100%',
//                     //style: 'padding:15px 5px;text-align:center;',
//                     items: [{
//                         columnWidth: .48,
//                         layout: 'form',
//                         items: [{
//                             /*xtype: 'modx-combo',
//                             url: tcBillboard.config.connector_url,
//                             baseParams: {
//                                 action: 'mgr/settings/status/getlist',
//                                 combo: true,
//                                 //addall: config.addall || 0,
//                                 order_id: config.order_id || 0
//                             },
//                             fields: ['id', 'name'],
//                             displayField: 'name',
//                             valueField: 'name',
//                             fieldLabel: _('tcbillboard_status'),
//                             id: 'tcbillboard-combo-status',
//                             width: 400,
//                             paging:true,
//                             pageSize:20,
//                             listeners: {
//                                 select: {
//                                     scope: this,
//                                     fn: function(formField, Obj) {
//                                         //Ext.getCmp('formit-grid-forms').baseParams.form = Obj.data.form;
//                                         //Ext.getCmp('formit-grid-forms').getBottomToolbar().changePage(1);
//                                         //Ext.getCmp('formit-grid-forms').refresh();
//
//                                         console.log(formField, Obj);
//                                     }
//                                 }
//                             }*/
//                             xtype: 'tcbillboard-combo-status',
//                             //id: config.id + '-status',
//                             name: 'status',
//                             fieldLabel: _('tcbillboard_status'),
//                             anchor: '100%',
//                             order_id: config.record.id
//                             // listeners: {
//                             //     select: {
//                             //         fn: function(a,b,c,d,e,f) {
//                             //
//                             //             console.log(a,b,c,d,e,f);
//                             //         }
//                             //     }
//                             // }
//                         }/*,{
//                             xtype: 'tcbillboard-combo-payment',
//                             //id: config.id + '-combo-payment',
//                             name: 'payment',
//                             fieldLabel: _('tcbillboard_payment'),
//                             anchor: '100%',
//                             payment_id: config.record.payment
//                         }*/]
//                     },{
//                         columnWidth: .48,
//                         layout: 'form',
//                         style: 'padding:15px 5px;text-align:center;',
//                         items: [{
//                             xtype: 'displayfield',
//                             name: 'sum',
//                             fieldLabel: _('tcbillbord_order_cost'),
//                             anchor: '100%',
//                             style: 'font-size:2em;'
//                         }]
//                     }]
//                 }]
//             }/*,{
//                 title: _('tcbillboard_order_ad'),
//                 layout: 'anchor',
//                 items: [{
//                     //xtype: 'tcbillboard-window-order-order-ad',
//                     cls: 'main-wrapper'
//                 }]
//             }*/]
//         };
//     },
//
//     getKeys: function () {
//         return {
//             key: Ext.EventObject.ENTER,
//             shift: true, fn: function () {
//                 this.submit()
//             }, scope: this
//         }
//     },
//
//     getListeners: function() {
//         return {};
//     }
// });
// Ext.reg('tcbillboard-order-window-update', tcBillboard.window.UpdateOrders);