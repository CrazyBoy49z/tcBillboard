tcBillboard.panel.ImportCSV = function(config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-form-import-csv';
    }
    Ext.apply(config,{
        url: tcBillboard.config.connector_url,
        baseParams: {
            action: 'mgr/manager/import/import'
        },
        fileUpload: true,
        layout: 'form',
        border: false,
        cls: 'main-wrapper',
        anchor: '60%',
        labelAlign: 'top',
        items: [{
            xtype: 'fileuploadfield',
            id: 'tcbillboard-import-fileupload',
            fieldLabel: _('tcbillboard_import_csv_file'),
            name: 'csv_data_file',
            listeners: {
                'fileselected': {
                    fn: function(fld, e) {
                        var btn = Ext.getCmp('tcbillboard-import-csv-button');
                        if(!Ext.isEmpty(fld.getValue())) {
                            btn.setDisabled(false);
                        } else {
                            btn.setDisabled(true);
                        }
                    },
                    scope: this
                }
            }
        },{
            html: '<br />',
            border: false
        },{
            xtype: 'button',
            id: 'tcbillboard-import-csv-button',
            text: _('tcbillboard_import'),
            anchor: 'auto',
            disabled: true,
            listeners: {
                'click': { fn: function() {
                        var formObj = Ext.getCmp('tcbillboard-form-import-csv').getForm();
                        if(formObj.isValid()) {
                            formObj.submit({
                                waitMsg: _('tcbillboard_importing'),
                                scope: this,
                                failure: function(form, response) {
                                    Ext.MessageBox.alert(_('tcbillboard_failed'), response.result.message);
                                },
                                success: function(form, response) {
                                    Ext.MessageBox.alert(_('tcbillboard_success'), response.result.message);
                                    Ext.getCmp('tcbillboard-form-import-csv').refresh();
                                }
                            });
                        }
                    },
                    scope: this
                }
            }
        }]
    });
    tcBillboard.panel.ImportCSV.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.panel.ImportCSV, MODx.FormPanel, {});
Ext.reg('tcbillboard-form-import-csv', tcBillboard.panel.ImportCSV);