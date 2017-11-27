tcBillboard.grid.Warning = function(config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-grid-warning';
    }
    this.sm = new Ext.grid.CheckboxSelectionModel();
    Ext.applyIf(config,{
        url: tcBillboard.config.connector_url,
        baseParams: {
            action: 'mgr/manager/warning/getlist'
        },
        fields: ['id','order_num','file', 'formed_date', 'downloaded', 'rank'],
        anchor: '100%',
        paging: true,
        sm: this.sm,
        columns: [this.sm,{
            header: _('tcbillboard_invoice'),
            dataIndex: 'order_num',
            width: 150,
            sortable: false
        },{
            header: _('tcbillboard_invoice_file'),
            dataindex: 'file',
            width: 300,
            sortable: false
        },{
            header: _('tcbillboard_formed'),
            dataindex: 'formed_date',
            width: 150,
            sortable: true
        },{
            header: _('tcbillboard_invoice_downloaded'),
            dataIndex: 'downloaded',
            width: 70,
            sortable: true,
            renderer: tcBillboard.utils.renderBoolean
        },{
            header: _('tcbillboard_notice'),
            dataIndex: 'rank',
            width: 100,
            sortable: true
        }]
    });
    tcBillboard.grid.Warning.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.grid.Warning, MODx.grid.Grid, {
    getMenu: function () {
        var m = [];
        var t = this.getSelectionModel().getCount() > 1
            ? '_all'
            : '';

        m.push({
            text: '<i class="icon icon-download"></i> ' + _('tcbillboard_download' + t),
            handler: function() {
                Ext.getCmp('tcbillboard-grid-warning').exportPdf();
            }
        });
        return m;
    },

    exportPdf: function() {
        var ids = this._getSelectedIds();
        var store = this.getStore();

        if (ids) {
            var _params = store.lastOptions.params;
            _params['action'] = 'mgr/manager/warning/getlist';
            _params['download'] = true;
            _params['init'] = 'export';
            _params['ids'] = ids;
            _params['HTTP_MODAUTH'] = MODx.siteId;

            _link = tcBillboard.config.connector_url + '?' + Ext.urlEncode(_params);
            var w = window.open(_link, '_self'); // _self - в текущем окне
            w.focus();
            _params['init'] = '';
            setTimeout(function() {
                Ext.getCmp('tcbillboard-grid-warning').refresh();
            }, 3000);
        } else {
            Ext.onReady(function() {
                MODx.msg.alert(_('error'), _('tcbillboard_select_one_field'));
            });
        }
    },

    _getSelectedIds: function () {
        var tmp = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            tmp.push(selected[i]['id']);
        }
        return tmp.join();
    }
});
Ext.reg('tcbillboard-grid-warning', tcBillboard.grid.Warning);