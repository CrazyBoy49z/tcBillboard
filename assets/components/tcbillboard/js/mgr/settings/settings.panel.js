tcBillboard.panel.Settings = function(config) {
    config = config || {};
    Ext.apply(config, {
        cls: 'container',
        items: [{
            html: '<h2>' + _('tcbillboard') + ' :: ' + _('tcbillboard_settings') + '</h2>',
            cls: 'modx-page-header',
        },{
            xtype: 'modx-tabs',
            id: 'tcbillboard-settings-tabs',
            stateful: true,
            stateId: 'tcbillboard-settings-tabs',
            stateEvents: ['tabchange'],
            //cls: 'minishop2-panel',
            getState: function () {
                return {
                    activeTab: this.items.indexOf(this.getActiveTab())
                };
            },
            items: [{
                title: _('tcbillboard_price'),
                layout: 'anchor',
                items: [{
                    html: _('tcbillboard_price_intro'),
                    bodyCssClass: 'panel-desc',
                }, {
                    xtype: 'tcbillboard-grid-price',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('tcbillboard_statuses'),
                layout: 'anchor',
                items: [{
                    html: _('tcbillboard_statuses_intro'),
                    bodyCssClass: 'panel-desc',
                }, {
                    xtype: 'tcbillboard-grid-status',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('tcbillboard_payment'),
                layout: 'anchor',
                items: [{
                    html: _('tcbillboard_payment_intro'),
                    bodyCssClass: 'panel-desc',
                }, {
                    xtype: 'tcbillboard-grid-payment',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('tcbillboard_penalty'),
                layout: 'anchor',
                items: [{
                    html: _('tcbillboard_penalty_intro'),
                    bodyCssClass: 'panel-desc',
                }, {
                    xtype: 'tcbillboard-grid-penalty',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    tcBillboard.panel.Settings.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.panel.Settings, MODx.Panel);
Ext.reg('tcbillboard-panel-settings', tcBillboard.panel.Settings);