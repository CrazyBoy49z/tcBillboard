tcBillboard.grid.Penalty = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-grid-penalty';
    }
    Ext.applyIf(config, {
        url: tcBillboard.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        //sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/settings/penalty/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updatePenalty(grid, e, row);
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
    });
    tcBillboard.grid.Penalty.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(tcBillboard.grid.Penalty, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = tcBillboard.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    createPenalty: function (btn, e) {
        var w = MODx.load({
            xtype: 'tcbillboard-penalty-window-create',
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

    updatePenalty: function (btn, e, row) {
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
                action: 'mgr/settings/penalty/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'tcbillboard-penalty-window-update',
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
    },

    removePenalty: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('tcbillboard_penalties_remove')
                : _('tcbillboard_penalty_remove'),
            text: ids.length > 1
                ? _('tcbillboard_penalties_remove_confirm')
                : _('tcbillboard_penalty_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/settings/penalty/remove',
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

    disablePenalty: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/penalty/disable',
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

    enablePenalty: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/penalty/enable',
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

    getFields: function () {
        return ['id', 'days', 'formula', 'percent', 'fine', 'description', 'chunk', 'active', 'actions'];
    },

    getColumns: function () {
        return [{
            header: 'ID',
            dataIndex: 'id',
            sortable: true,
            width: 50
        },{
            header: _('tcbillboard_days'),
            dataIndex: 'days',
            sortable: true,
            width: 100
        },{
            header: _('tcbillboard_percent'),
            dataIndex: 'percent',
            sortable: true,
            width: 100
        },{
            header: _('tcbillboard_fine'),
            dataIndex: 'fine',
            sortable: true,
            width: 100
        },{
            header: _('tcbillboard_formula'),
            dataIndex: 'formula',
            sortable: true,
            width: 100
        },{
            header: _('tcbillboard_description'),
            dataIndex: 'description',
            sortable: false,
            width: 250
        },{
            header: _('tcbillboard_email_chunk'),
            dataIndex: 'chunk',
            sortable: false,
            width: 100
        },{
            header: _('tcbillboard_active'),
            dataIndex: 'active',
            renderer: tcBillboard.utils.renderBoolean,
            sortable: true,
            width: 100
        }, {
            header: _('tcbillboard_actions'),
            dataIndex: 'actions',
            renderer: tcBillboard.utils.renderActions,
            sortable: false,
            width: 100,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('tcbillboard_create'),
            handler: this.createPenalty,
            scope: this
        }];
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
    },

    _doSearch: function (tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    }
});
Ext.reg('tcbillboard-grid-penalty', tcBillboard.grid.Penalty);
