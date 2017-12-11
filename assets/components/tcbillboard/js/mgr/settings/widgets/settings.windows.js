tcBillboard.window.CreatePrice = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-price-window-create';
    }
    Ext.applyIf(config, {
        title: _('tcbillboard_price_create'),
        width: 550,
        autoHeight: true,
        url: tcBillboard.config.connector_url,
        action: 'mgr/settings/price/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    tcBillboard.window.CreatePrice.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.window.CreatePrice, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id'
        },{
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('tcbillboard_price_period'),
                    name: 'period',
                    anchor: '99%',
                    allowBlank: false
                },{

                }]
            },{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('tcbillboard_price_price_unit'),
                    name: 'price',
                    decimalPrecision: 2,
                    anchor: '99%',
                    allowBlank: false
                }]
            }]
        },{
            layout: 'column',
            defaults: {msgTarget: 'under'},
            items: [{
                columnWidth: .5,
                layout: 'form',
                //defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'xdatetime',
                    fieldLabel: _('tcbillboard_price_graceperiod'),
                    name: 'graceperiod',
                    allowBlank: true,
                    dateFormat: MODx.config.manager_date_format,
                    timeFormat: MODx.config.manager_time_format,
                    startDay: parseInt(MODx.config.manager_week_start),
                    dateWidth: 200,
                    timeWidth: 120,
                    offset_time: MODx.config.server_offset_time
                }]
            },{
                columnWidth: .5,
                layout: 'form',
                //defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('tcbillboard_price_graceperiod_price'),
                    name: 'graceperiodprice',
                    anchor: '99%'
                }]
            }]
        },{
            xtype: 'xcheckbox',
            boxLabel: _('tcbillboard_enabled'),
            name: 'active',
            checked: true
        }];
    },
});
Ext.reg('tcbillboard-price-window-create', tcBillboard.window.CreatePrice);


tcBillboard.window.UpdatePrice = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-price-window-update';
    }
    Ext.applyIf(config, {
        title: _('tcbillboard_price_update'),
        width: 550,
        autoHeight: true,
        url: tcBillboard.config.connector_url,
        action: 'mgr/settings/price/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    tcBillboard.window.UpdatePrice.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.window.UpdatePrice, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id'
        },{
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('tcbillboard_price_period'),
                    name: 'period',
                    anchor: '99%',
                    allowBlank: false
                },{

                }]
            },{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('tcbillboard_price_price_unit'),
                    name: 'price',
                    decimalPrecision: 2,
                    anchor: '99%',
                    allowBlank: false
                }]
            }]
        },{
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'xdatetime',
                    fieldLabel: _('tcbillboard_price_graceperiod'),
                    name: 'graceperiod',
                    allowBlank: true,
                    dateFormat: MODx.config.manager_date_format,
                    timeFormat: MODx.config.manager_time_format,
                    startDay: parseInt(MODx.config.manager_week_start),
                    dateWidth: 200,
                    timeWidth: 120,
                    offset_time: MODx.config.server_offset_time
                }]
            },{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('tcbillboard_price_graceperiod_price'),
                    name: 'graceperiodprice',
                    anchor: '99%'
                }]
            }]
        },{
            xtype: 'xcheckbox',
            boxLabel: _('tcbillboard_enabled'),
            name: 'active',
            checked: true
        }];
    }
});
Ext.reg('tcbillboard-price-window-update', tcBillboard.window.UpdatePrice);

/*----------------------------------------------------------------------------*/

tcBillboard.window.CreateStatus = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-status-window-create';
    }
    Ext.applyIf(config, {
        title: _('tcbillboard_status_create'),
        width: 550,
        autoHeight: true,
        record: {},
        url: tcBillboard.config.connector_url,
        action: 'mgr/settings/status/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER,
            shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    tcBillboard.window.CreateStatus.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.window.CreateStatus, MODx.Window, {

    getFields: function (config) {
        return [
            {xtype: 'hidden', name: 'id', id: config.id + '-id'},
            /*{xtype: 'hidden', name: 'color', id: config.id + '-color' },*/
            {
                xtype: 'textfield',
                id: config.id + '-name',
                fieldLabel: _('tcbillboard_name'),
                name: 'name',
                anchor: '99%'
            },/*{
                xtype: 'colorpalette',
                fieldLabel: _('tcbillboard_status_color'),
                id: config.id + '-color-palette',
                listeners: {
                    select: function (palette, color) {
                        Ext.getCmp(config.id + '-color').setValue(color)
                    },
                    beforerender: function (palette) {
                        if (config.record['color'] != undefined) {
                            palette.value = config.record['color'];
                        }
                    }
                }
            },*/{
                layout: 'column',
                items: [{
                    columnWidth: .5,
                    layout: 'form',
                    items: [{
                        xtype: 'xcheckbox',
                        id: config.id + '-email-user',
                        boxLabel: _('tcbillboard_status_email_user'),
                        name: 'email_user',
                        listeners: {
                            check: {
                                fn: function (checkbox) {
                                    this.handleStatusFields(checkbox);
                                }, scope: this
                            },
                            afterrender: {
                                fn: function (checkbox) {
                                    this.handleStatusFields(checkbox);
                                }, scope: this
                            }
                        }
                    },{
                        xtype: 'textfield',
                        id: config.id + '-subject-user',
                        fieldLabel: _('tcbillboard_status_subject_user'),
                        name: 'subject_user',
                        anchor: '99%'
                    },{
                        xtype: 'tcbillboard-combo-chunk',
                        fieldLabel: _('tcbillboard_status_chunk_user'),
                        name: 'chunk_user',
                        id: config.id + '-chunk-user',
                        anchor: '99%'
                    }]
                },{
                    columnWidth: .5,
                    layout: 'form',
                    items: [{
                        xtype: 'xcheckbox',
                        id: config.id + '-email-manager',
                        boxLabel: _('tcbillboard_status_email_manager'),
                        name: 'email_manager',
                        listeners: {
                            check: {
                                fn: function (checkbox) {
                                    this.handleStatusFields(checkbox);
                                }, scope: this
                            },
                            afterrender: {
                                fn: function (checkbox) {
                                    this.handleStatusFields(checkbox);
                                }, scope: this
                            }
                        }
                    },{
                        xtype: 'textfield',
                        id: config.id + '-subject-manager',
                        fieldLabel: _('tcbillboard_status_subject_manager'),
                        name: 'subject_manager',
                        anchor: '99%'
                    },{
                        xtype: 'tcbillboard-combo-chunk',
                        id: config.id + '-chunk-manager',
                        fieldLabel: _('tcbillboard_status_chunk_manager'),
                        name: 'chunk_manager',
                        anchor: '99%'
                    }]
                }]
            },{
                xtype: 'textarea',
                id: config.id + '-description',
                fieldLabel: _('tcbillboard_description'),
                name: 'description',
                anchor: '99%',
            },{
                xtype: 'checkboxgroup',
                hideLabel: true,
                columns: 3,
                items: [{
                    xtype: 'xcheckbox',
                    id: config.id + '-active',
                    boxLabel: _('tcbillboard_active'),
                    name: 'active',
                    checked: parseInt(config.record['active']),
                }, {
                    xtype: 'xcheckbox',
                    id: config.id + '-final',
                    boxLabel: _('tcbillboard_status_final'),
                    description: _('tcbillboard_status_final_help'),
                    name: 'final',
                    checked: parseInt(config.record['final']),
                }, {
                    xtype: 'xcheckbox',
                    id: config.id + '-fixed',
                    boxLabel: _('tcbillboard_status_fixed'),
                    description: _('tcbillboard_status_fixed_help'),
                    name: 'fixed',
                    checked: parseInt(config.record['fixed']),
                }]
            }
        ]
    },

    handleStatusFields: function (checkbox) {
        var type = checkbox.name.replace(/(^.*?_)/, '');

        var subject = Ext.getCmp(this.config.id + '-subject-' + type);
        var chunk = Ext.getCmp(this.config.id + '-chunk-' + type);

        if (checkbox.checked) {
            subject.enable().show();
            chunk.enable().show();
        } else {
            subject.hide().disable();
            chunk.hide().disable();
        }
    }
});
Ext.reg('tcbillboard-status-window-create', tcBillboard.window.CreateStatus);

tcBillboard.window.UpdateStatus = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('tcbillboard_update'),
        baseParams: {
            action: 'mgr/settings/status/update'
        }
    });
    tcBillboard.window.UpdateStatus.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.window.UpdateStatus, tcBillboard.window.CreateStatus);
Ext.reg('tcbillboard-status-window-update', tcBillboard.window.UpdateStatus);

/*----------------------------------------------------------------------------*/

tcBillboard.window.CreatePayment = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-payment-window-create';
    }
    Ext.applyIf(config, {
        title: _('tcbillboard_payment_create'),
        width: 550,
        autoHeight: true,
        url: tcBillboard.config.connector_url,
        action: 'mgr/settings/payment/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    tcBillboard.window.CreatePayment.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.window.CreatePayment, MODx.Window, {
    getFields: function (config) {
        return [
            {xtype: 'hidden', name: 'id', id: config.id + '-id'},
            {
                xtype: 'textfield',
                fieldLabel: _('tcbillboard_name'),
                name: 'name',
                anchor: '99%',
                allowBlank: false
            },{
                xtype: 'textarea',
                fieldLabel: _('tcbillboard_description'),
                name: 'description',
                height: 150,
                anchor: '99%'
            }, {
                xtype: 'xcheckbox',
                boxLabel: _('modextra_item_active'),
                name: 'active',
                checked: true
            }
        ]
    }
});
Ext.reg('tcbillboard-payment-window-create', tcBillboard.window.CreatePayment);

tcBillboard.window.UpdatePayment = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('tcbillboard_update'),
        baseParams: {
            action: 'mgr/settings/payment/update'
        }
    });
    tcBillboard.window.UpdatePayment.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.window.UpdatePayment, tcBillboard.window.CreatePayment);
Ext.reg('tcbillboard-payment-window-update', tcBillboard.window.UpdatePayment);

/*----------------------------------------------------------------------------*/

tcBillboard.window.CreatePenalty= function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-penalty-window-create';
    }
    Ext.applyIf(config, {
        title: _('tcbillboard_penalty_create'),
        width: 550,
        autoHeight: true,
        url: tcBillboard.config.connector_url,
        action: 'mgr/settings/penalty/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER,
            shift: true,
            fn: function () {
                this.submit()
            },
            scope: this
        }]
    });
    tcBillboard.window.CreatePenalty.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.window.CreatePenalty, MODx.Window, {
    getFields: function (config) {
        return [
            {xtype: 'hidden', name: 'id', id: config.id + '-id'},
            {
                xtype: 'numberfield',
                fieldLabel: _('tcbillboard_penalty_many_days_to'),
                name: 'days',
                anchor: '99%',
                allowBlank: false
            },{
                xtype: 'numberfield',
                fieldLabel: _('tcbillboard_percent'),
                name: 'percent',
                anchor: '99%',
                allowBlank: false
            },{
                xtype: 'numberfield',
                fieldLabel: _('tcbillboard_fine'),
                name: 'fine',
                anchor: '99%',
                allowBlank: false
            },{
                xtype: 'textarea',
                fieldLabel: _('tcbillboard_description'),
                name: 'description',
                height: 150,
                anchor: '99%'
            },{
                xtype: 'tcbillboard-combo-chunk',
                id: config.id + '-chunk',
                fieldLabel: _('tcbillboard_penalty_chunk'),
                name: 'chunk',
                anchor: '99%'
            },{
                xtype: 'xcheckbox',
                boxLabel: _('tcbillboard_active'),
                name: 'active',
                checked: true
            }
        ]
    }
});
Ext.reg('tcbillboard-penalty-window-create', tcBillboard.window.CreatePenalty);

tcBillboard.window.UpdatePenalty = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('tcbillboard_update'),
        baseParams: {
            action: 'mgr/settings/penalty/update'
        }
    });
    tcBillboard.window.UpdatePenalty.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.window.UpdatePenalty, tcBillboard.window.CreatePenalty);
Ext.reg('tcbillboard-penalty-window-update', tcBillboard.window.UpdatePenalty);

/*----------------------------------------------------------------------------*/