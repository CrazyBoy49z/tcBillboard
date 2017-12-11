tcBillboard.grid.Status = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-grid-status';
    }
    Ext.applyIf(config, {
        url: tcBillboard.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/settings/status/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateStatus(grid, e, row);
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
        stateId: config.id,
        enableDragDrop: true,
    });
    tcBillboard.grid.Status.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.grid.Status, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = tcBillboard.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    getFields: function () {
        return [
            'id', 'name', 'description', 'color', 'email_user', 'email_manager',
            'subject_user', 'subject_manager', 'chunk_user', 'chunk_manager', 'active',
            'final', 'fixed', 'rank', 'editable', 'actions'
        ];
    },

    getColumns: function () {
        return [
            {header: 'ID', dataIndex: 'id', width: 30},
            {header: _('tcbillboard_name'), dataIndex: 'name', width: 50, renderer: this._renderColor},
            {header: _('tcbillboard_status_email_user'), dataIndex: 'email_user', width: 50, renderer: this._renderBoolean},
            {header: _('tcbillboard_status_email_manager'), dataIndex: 'email_manager', width: 50, renderer: this._renderBoolean},
            {header: _('tcbillboard_status_final'), dataIndex: 'final', width: 50, renderer: this._renderBoolean},
            {header: _('tcbillboard_status_fixed'), dataIndex: 'fixed', width: 50, renderer: this._renderBoolean},
            {header: _('tcbillboard_status_rank'), dataIndex: 'rank', width: 35, hidden: true},
            {
                header: _('tcbillboard_active'),
                dataIndex: 'active',
                renderer: tcBillboard.utils.renderBoolean,
                sortable: true,
                width: 50
            },{
                header: _('tcbillboard_actions'),
                dataIndex: 'actions',
                renderer: tcBillboard.utils.renderActions,
                sortable: false,
                width: 50,
                id: 'actions'
            }
        ];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i> ' + _('tcbillboard_create'),
            handler: this.createStatus,
            scope: this
        }];
    },

    createStatus: function (btn, e) {
        var w = Ext.getCmp('tcbillboard-status-window-create');
        if (w) {
            w.close();
        }
        w = MODx.load({
            xtype: 'tcbillboard-status-window-create',
            id: 'tcbillboard-status-window-create',
            record: {
                color: '000000',
                active: 1
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.show(e.target);
    },

    updateStatus: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }

        var w = Ext.getCmp('tcbillboard-status-window-update');
        if (w) {
            w.close();
        }

        w = MODx.load({
            xtype: 'tcbillboard-status-window-update',
            id: 'tcbillboard-status-window-update',
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

    enableStatus: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/status/enable',
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

    disableStatus: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/settings/status/disable',
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

    removeStatus: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }

        MODx.msg.confirm({
            title: ids.length > 1
                ? _('tcbillboard_statuses_remove')
                : _('tcbillboard_status_remove'),
            text: ids.length > 1
                ? _('tcbillboard_statuses_remove_confirm')
                : _('tcbillboard_status_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/settings/status/remove',
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

    _renderColor: function (value, cell, row) {
        //noinspection CssInvalidPropertyValue
        return row.data['active']
            ? String.format('<span style="color:#{0}">{1}</span>', row.data['color'], value)
            : value;
    },

    _renderBoolean: function(value, cell, row) {
        var color, text;

        if (value == 0 || value == false || value == undefined) {
            color = 'red';
            text = _('no');
        }
        else {
            color = 'green';
            text = _('yes');
        }

        return row.data['active']
            ? String.format('<span class="{0}">{1}</span>', color, text)
            : text;
    }
});
Ext.reg('tcbillboard-grid-status', tcBillboard.grid.Status);