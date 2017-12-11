tcBillboard.combo.listeners_disable = {
    render: function () {
        this.store.on('load', function () {
            if (this.store.getTotalCount() == 1 && this.store.getAt(0).id == this.value) {
                this.readOnly = true;
                this.addClass('disabled');
            }
            else {
                this.readOnly = false;
                this.removeClass('disabled');
            }
        }, this);
    }
};


tcBillboard.combo.Status = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: 'status',
        id: 'tcbillboard-combo-status',
        hiddenName: 'status',
        displayField: 'name',
        valueField: 'id',
        fields: ['id', 'name'],
        pageSize: 10,
        emptyText: _('tcbillboard_status_select'),
        url: tcBillboard.config.connector_url,
        baseParams: {
            action: 'mgr/settings/status/getlist',
            combo: true,
            addall: config.addall || 0,
            order_id: config.order_id || 0
        },
        listeners: tcBillboard.combo.listeners_disable
    });
    tcBillboard.combo.Status.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.combo.Status, MODx.combo.ComboBox);
Ext.reg('tcbillboard-combo-status', tcBillboard.combo.Status);


tcBillboard.combo.Payment = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: 'payment',
        //id: 'tcbillboard-combo-payment',
        hiddenName: 'payment',
        displayField: 'name',
        valueField: 'id',
        //editable: true,
        //disabled: false,
        fields: ['id', 'name'],
        pageSize: 10,
        paging:true,
        emptyText: _('tcbillboard_combo_select'),
        url: tcBillboard.config.connector_url,
        baseParams: {
            action: 'mgr/settings/payment/getlist',
            combo: true,
            addall: 0,
            payment_id: config.payment_id || 0
        },
        listeners: tcBillboard.combo.listeners_disable
    });
    tcBillboard.combo.Payment.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.combo.Payment, MODx.combo.ComboBox);
Ext.reg('tcbillboard-combo-payment', tcBillboard.combo.Payment);


tcBillboard.combo.Chunk = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'chunk',
        hiddenName: config.name || 'chunk',
        displayField: 'name',
        valueField: 'id',
        editable: true,
        fields: ['id', 'name'],
        pageSize: 20,
        emptyText: _('tcbillboard_status_combo_select'),
        hideMode: 'offsets',
        url: tcBillboard.config.connector_url,
        baseParams: {
            action: 'mgr/system/element/chunk/getlist',
            mode: 'chunks'
        }
    });
    tcBillboard.combo.Chunk.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.combo.Chunk, MODx.combo.ComboBox);
Ext.reg('tcbillboard-combo-chunk', tcBillboard.combo.Chunk);