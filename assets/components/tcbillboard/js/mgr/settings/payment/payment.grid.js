tcBillboard.grid.Payment = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-grid-payment';
    }
    Ext.applyIf(config, {
        url: tcBillboard.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/settings/payment/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updatePrice(grid, e, row);
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                return !rec.data.active
                    ? 'tcbillboard-grid-row-disabled'
                    : '';
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
        multi_select: true,
        changed: false,
        stateful: true,
        stateId: config.id
    });
    tcBillboard.grid.Payment.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.grid.Payment, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = tcBillboard.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    getFields: function () {
        return [
            'id', 'name', 'active', 'actions'
        ];
    },
    getColumns: function () {
        return [
            {
                header: 'ID', dataIndex: 'id', width: 70
            },{
                header: _('tcbillboard_payment_name'), dataIndex: 'name', width: 150
            },{
                header: _('tcbillboard_active'),
                dataIndex: 'active',
                renderer: tcBillboard.utils.renderBoolean,
                sortable: true,
                width: 100
            },{
                header: _('tcbillboard_actions'),
                dataIndex: 'actions',
                renderer: tcBillboard.utils.renderActions,
                sortable: false,
                width: 100,
                id: 'actions'
            }
        ]
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('tcbillboard_create'),
            handler: this.createPayment,
            scope: this
        }/*, '->', {
            xtype: 'tcbillboard-field-search',
            width: 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        }*/];
    },

    createPayment: function (btn, e) {
        var w = MODx.load({
            xtype: 'tcbillboard-payment-window-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({active: true});
        w.show(e.target);
    },

    /*updatePayment: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/payment/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'tcbillboard-payment-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },*/

    updatePayment: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }

        var w = Ext.getCmp('tcbillboard-payment-window-update');
        if (w) {
            w.close();
        }

        console.log(btn, e, row);

        w = MODx.load({
            xtype: 'tcbillboard-payment-window-update',
            id: 'tcbillboard-payment-window-update',
            title: this.menu.record['name'],
            record: this.menu.record,
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.fp.getForm().reset();
        w.fp.getForm().setValues(this.menu.record);
        w.show(e.target);
    },

    removePayment: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('tcbillboard_prices_remove')
                : _('tcbillboard_price_remove'),
            text: ids.length > 1
                ? _('tcbillboard_prices_remove_confirm')
                : _('tcbillboard_price_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/settings/payment/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    disablePayment: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/payment/disable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    enablePayment: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/payment/enable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    }
});
Ext.reg('tcbillboard-grid-payment', tcBillboard.grid.Payment);