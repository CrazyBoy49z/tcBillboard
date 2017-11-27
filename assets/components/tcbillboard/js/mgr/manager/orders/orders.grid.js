tcBillboard.grid.Orders = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-grid-orders';
    }
    Ext.applyIf(config, {
        url: tcBillboard.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        //tbar: this.getTopBar(config),
        //sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/manager/orders/getlist',
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateOrder(grid, e, row);
            },
            /*afterrender: function (grid) {
                var params = tcBillboard.utils.Hash.get();
                var order = params['order'] || '';
                if (order) {
                    this.updateOrder(grid, Ext.EventObject, {data: {id: order}});
                }
            }*/
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                if (rec.data.notice == 1) {
                    return 'tcbillboard-notice-1';
                } else if (rec.data.notice == 2) {
                    return 'tcbillboard-notice-2';
                } else {
                    return '';
                }
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
        multi_select: true,
        changed: false,
        stateful: true,
        stateId: config.id,
        enableDragDrop: true
    });
    tcBillboard.grid.Orders.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.grid.Orders, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = tcBillboard.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    getFields: function () {
        return ['id', 'num', 'createdon', 'user_fullname', 'user_id', 'res_id', 'stock_name', 'pubdatedon', 'unpubdatedon',
            'sum', 'payment_name', 'status', 'status_name', 'paymentdate', 'notice', 'penalty', 'actions'
        ];

        //return ['id', 'num', 'createdon', 'user_id', 'res_id', 'status', 'actions'];
    },

    getColumns: function () {
        return [{
            header: 'ID', dataIndex: 'id', width: 50
        },{
            header: _('tcbillboard_invoice'), dataIndex: 'num', width: 150
        },{
            header: _('tcbillboard_createdon'), dataIndex: 'createdon', width: 150
        },{
            header: _('tcbillboard_user_id'),
            dataIndex: 'user_fullname',
            renderer: function(val, cell, row) {
                return tcBillboard.utils.userLink(val, row.data['user_id'], true);
            },
            width: 200
        },{
            header: _('tcbillboard_stock_name'),
            dataIndex: 'stock_name',
            renderer: function(val, cell, row) {
                return tcBillboard.utils.pagetitleLink(val, row.data['res_id'], true);
            },
            width: 200
        },{
            header: _('tcbillboard_account'), dataIndex: 'sum', width: 100
        },{
            header: _('tcbillboard_payment'), dataIndex: 'payment_name', width: 150
        },{
            header: _('tcbillboard_status'), dataIndex: 'status', /*sortable: true,*/ width: 100
        },{
            header: _('tcbillboard_paymentdate'), dataIndex: 'paymentdate', width: 150
        },{
            header: _('tcbillboard_pubdatedon'), dataIndex: 'pubdatedon', width: 150
        },{
            header: _('tcbillboard_unpubdatedon'), dataIndex: 'unpubdatedon', width: 150
        },{
            header: _('tcbillboard_notice'),
            dataIndex: 'notice',
            renderer: tcBillboard.utils.renderNotice,
            //sortable: true,
            width: 150
        },{
            header: _('tcbillboard_penalty'), dataIndex: 'penalty', width: 100
        },{
            header: _('tcbillboard_actions'),
            dataIndex: 'actions',
            renderer: tcBillboard.utils.renderActions,
            //sortable: false,
            width: 100,
            id: 'actions'
        }]
    },

    export: function(btn, e) {
        var store = this.getStore();
        var _params = store.lastOptions.params;
        _params['action'] = 'mgr/manager/orders/getlist';
        _params['download'] = true;
        _params['init'] = 'export';
        _params['HTTP_MODAUTH'] = MODx.siteId;

        _link = tcBillboard.config.connector_url + '?' + Ext.urlEncode(_params);
        var win = window.open(_link, '_blank'); // _self - в текущем окне
        //win.focus();
        _params['init'] = '';

        //console.log(store);
    },

    updateOrder: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/manager/orders/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = Ext.getCmp('tcbillboard-order-window-update');
                        if (w) {
                            w.close();
                        }

                        w = MODx.load({
                            xtype: 'tcbillboard-order-window-update',
                            //id: 'tcbillboard-order-window-update',
                            record: r.object,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                },
                                hide: {
                                    fn: function () {
                                        tcBillboard.utils.Hash.remove('order');
                                        if (tcBillboard.grid.Orders.changed === true) {
                                            Ext.getCmp('tcbillboard-grid-orders').getStore().reload();
                                            tcBillboard.grid.Orders.changed = false;
                                        }
                                    }
                                },
                                afterrender: function () {
                                    tcBillboard.utils.Hash.add('order', r.object['id']);
                                }
                            }
                        });
                        w.fp.getForm().reset();
                        w.fp.getForm().setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    // updateOrder: function (btn, e, row) {
    //     if (typeof(row) != 'undefined') {
    //         this.menu.record = row.data;
    //     }
    //
    //     var w = Ext.getCmp('tcbillboard-order-window-update');
    //     if (w) {
    //         w.close();
    //     }
    //
    //     w = MODx.load({
    //         xtype: 'tcbillboard-order-window-update',
    //         id: 'tcbillboard-order-window-update',
    //         title: this.menu.record['name'],
    //         record: this.menu.record,
    //         listeners: {
    //             success: {
    //                 fn: function () {
    //                     this.refresh();
    //                 }, scope: this
    //             }
    //         }
    //     });
    //     w.fp.getForm().reset();
    //     w.fp.getForm().setValues(this.menu.record);
    //     w.show(e.target);
    // },

    /*removeOrder: function () {
        var ids = this._getSelectedIds();

        Ext.MessageBox.confirm(
            _('ms2_menu_remove_title'),
            ids.length > 1
                ? _('ms2_menu_remove_multiple_confirm')
                : _('ms2_menu_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.orderAction('remove');
                }
            }, this
        );
    },

    _renderCost: function (val, idx, rec) {
        return rec.data['type'] != undefined && rec.data['type'] == 1
            ? '-' + val
            : val;
    },*/

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

});
Ext.reg('tcbillboard-grid-orders', tcBillboard.grid.Orders);
