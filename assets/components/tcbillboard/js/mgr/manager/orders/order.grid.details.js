tcBillboard.grid.OrderDetails = function(config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-order-grid-details';
    }
    Ext.applyIf(config, {
        url: tcBillboard.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        baseParams: {
            action: 'mgr/manager/orders/getlist',
            order_id: config.order_id,
            details: true
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                //this.updateOrder(grid, e, row);
            },
            /*afterrender: function (grid) {
                var params = tcBillboard.utils.Hash.get();
                var order = params['order'] || '';
                if (order) {
                    this.updateOrder(grid, Ext.EventObject, {data: {id: order}});
                }
            }*/
        },
        multi_select: false,
        stateful: true,
        stateId: config.id,
        //pageSize: Math.round(MODx.config['default_per_page'] / 2),
    });
    tcBillboard.grid.OrderDetails.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.grid.OrderDetails, MODx.grid.Grid, {
    windows: {},

    getFields: function() {
        return [
            'id', 'stock_name', 'res_id'
        ];
    },

    getColumns: function(){
        return [{
            header: 'ID', dataIndex: 'id', hidden: true
        },{
            header: _('tcbillboard_stock_name'),
            dataIndex: 'stock_name',
            renderer: function(value, metaData, record) {
                return tcBillboard.utils.pagetitleLink(value, record['data']['res_id'], true);
            },
            width: 200
        }];
    }
});
Ext.reg('tcbillboard-order-grid-details', tcBillboard.grid.OrderDetails);