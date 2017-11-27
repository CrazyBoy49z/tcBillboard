tcBillboard.panel.WarningForm = function(config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-form-warning';
    }
    Ext.apply(config,{
        layout: 'form',
        border: false,
        cls: 'main-wrapper',
        anchor: '100% 100%',
        items: [{
            layout: 'column',
            items: [{
                columnWidth: .33,
                layout: 'form',
                defaults: {anchor: '100%', hideLabel: true},
                items: [{
                    xtype: 'datefield',
                    id: config.id + '-begin',
                    emptyText: _('tcbillboard_orders_after'),
                    name: 'date_start',
                    format: MODx.config['manager_date_format'] || 'Y-m-d',
                    listeners: {
                        select: {
                            fn: function(dateField, dateObject) {
                                Ext.getCmp('tcbillboard-grid-warning').baseParams.date_start = dateObject;
                                Ext.getCmp('tcbillboard-grid-warning').getBottomToolbar().changePage(1);
                                Ext.getCmp('tcbillboard-grid-warning').refresh();
                            },
                            scope: this
                        }
                    }
                }]
            },{
                columnWidth: .33,
                layout: 'form',
                defaults: {anchor: '100%', hideLabel: true},
                items: [{
                    xtype: 'datefield',
                    id: config.id + '-end',
                    emptyText: _('tcbillboard_orders_before'),
                    name: 'date_end',
                    format: MODx.config['manager_date_format'] || 'Y-m-d',
                    listeners: {
                        select: {
                            fn: function(dateField, dateObject) {
                                Ext.getCmp('tcbillboard-grid-warning').baseParams.date_end = dateObject;
                                Ext.getCmp('tcbillboard-grid-warning').getBottomToolbar().changePage(1);
                                Ext.getCmp('tcbillboard-grid-warning').refresh();
                            },
                            scope: this
                        }
                    }
                }]
            },{
                columnWidth: .3,
                //layout: 'form',
                defaults: {anchor: '100%', hideLabel: true},
                items: [{
                    buttons: this.getButtons(config),
                }]
            }]
        }]
    });
    tcBillboard.panel.WarningForm.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.panel.WarningForm, MODx.FormPanel, {

    getButtons: function () {
        return [{
            text: '<i class="icon icon-times"></i> ' + _('tcbillboard_reset'),
            handler: this.reset,
            scope: this,
            cls: 'btn',
            iconCls: 'x-btn-small'
        },{
            text: '<i class="icon icon-download"></i> ' + _('tcbillboard_download'),
            handler: function() {
                Ext.getCmp('tcbillboard-grid-warning').exportPdf();
            },
            cls: 'btn',
            iconCls: 'x-btn-small'
        }]
    },

    reset: function () {
        var store = Ext.getCmp('tcbillboard-grid-warning').getStore();
        var form = this.getForm();

        form.items.each(function(f) {
            if (f.name == 'status') {
                f.clearValue();
            }
            else {
                f.reset();
            }
        });

        var values = form.getValues();
        for (var i in values) {
            if (values.hasOwnProperty(i)) {
                store.baseParams[i] = '';
            }
        }
        this.refresh();
    },

    refresh: function () {
        Ext.getCmp('tcbillboard-grid-warning').getBottomToolbar().changePage(1);
    }
});
Ext.reg('tcbillboard-form-warning', tcBillboard.panel.WarningForm);