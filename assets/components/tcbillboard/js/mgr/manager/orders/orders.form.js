tcBillboard.panel.OrdersForm = function(config) {
    config = config || {};
    if (!config.id) {
        config.id = 'tcbillboard-form-orders';
    }
    Ext.apply(config,{
        layout: 'form',
        border: false,
        cls: 'main-wrapper',
        anchor: '100% 100%',
        buttons: this.getButtons(config),
        items: [{
            layout: 'column',
            items: [{
                columnWidth: .33,
                layout: 'form',
                defaults: {anchor: '100%', hideLabel: true},
                items: [{
                    xtype: 'datefield',
                    //vtype: 'daterange',
                    //vfield: 'enddate',
                    id: config.id + '-begin',
                    //id: 'startdate',
                    //endDateField: 'enddate-date',
                    emptyText: _('tcbillboard_orders_after'),
                    name: 'date_start',
                    format: MODx.config['manager_date_format'] || 'Y-m-d',
                    listeners: {
                        select: {
                            fn: function(dateField, dateObject) {
                                Ext.getCmp('tcbillboard-grid-orders').baseParams.date_start = dateObject;
                                Ext.getCmp('tcbillboard-grid-orders').getBottomToolbar().changePage(1);
                                Ext.getCmp('tcbillboard-grid-orders').refresh();
                            },
                            scope: this
                        }
                    }
                },{
                    xtype: 'datefield',
                    //vtype: 'daterange',
                    //vfield: 'startdate',
                    id: config.id + '-end',
                    //id: 'enddate',
                    //startDateField: 'startdate-date',
                    emptyText: _('tcbillboard_orders_before'),
                    name: 'date_end',
                    format: MODx.config['manager_date_format'] || 'Y-m-d',
                    listeners: {
                        select: {
                            fn: function(dateField, dateObject) {
                                Ext.getCmp('tcbillboard-grid-orders').baseParams.date_end = dateObject;
                                Ext.getCmp('tcbillboard-grid-orders').getBottomToolbar().changePage(1);
                                Ext.getCmp('tcbillboard-grid-orders').refresh();
                            },
                            scope: this
                        }
                    }
                }]
            },{
                columnWidth: .67,
                layout: 'form',
                items: [{
                    id: 'tcbillboard-chart-orders',
                    listeners: {
                        render: {
                            fn: function (a,b) {
                                this.ChartT(config);
                            }, scope: this
                        }, single: true
                    }
                }]
            }]
        }]
    });
    tcBillboard.panel.OrdersForm.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.panel.OrdersForm, MODx.FormPanel, {

    ChartT: function () {
        if (!Ext.get('tcbillboard-highlight')) {
            container = Ext.get('tcbillboard-chart-orders');
            Ext.DomHelper.append(container, {tag: 'div', id: 'tcbillboard-highlight'});
        }

        var id = 'tcbillboard-highlight';

        Highcharts.chart(id, {
            chart: {
                type: 'column',
                height: 200
            },
            title: {
                text: null
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total percent'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    cursor: 'pointer',
                    allowPointSelect: true,
                    //selected: true,
                    marker: {
                        states: {
                            select: {
                                lineColor: 'red'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    },
                    point: {
                        events: {
                            click: function () {
                                if (this.selected) {
                                    Ext.getCmp('tcbillboard-grid-orders').baseParams.chart = null;
                                } else {
                                    Ext.getCmp('tcbillboard-grid-orders').baseParams.chart = this.val;
                                }
                                Ext.getCmp('tcbillboard-grid-orders').getBottomToolbar().changePage(1);
                                Ext.getCmp('tcbillboard-grid-orders').refresh();
                            }
                        }
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: _('tcbillboard_payment_name'),
                colorByPoint: true,
                data: [{
                    name: _('tcbillboard_front_bank_transfer'),
                    y: tcBillboard.config.payment.bank,
                    //drilldown: 'Банковский перевод',
                    val: 1
                }, {
                    name: 'PayPal',
                    y: tcBillboard.config.payment.PayPal,
                    val: 2
                    //drilldown: 'PayPal'
                }]
            }]
        });
    },

    getButtons: function () {
        return [{
            text: '<i class="icon icon-times"></i> ' + _('tcbillboard_reset'),
            handler: this.reset,
            scope: this,
            cls: 'btn',
            iconCls: 'x-btn-small',
        },{
            text: '<i class="icon icon-download"></i> ' + _('tcbillboard_download_csv'),
            handler: function() {
                Ext.getCmp('tcbillboard-grid-orders').export();
            },
            cls: 'btn',
            iconCls: 'x-btn-small'
        }]
    },

    reset: function () {
        var store = Ext.getCmp('tcbillboard-grid-orders').getStore();
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
        Ext.getCmp('tcbillboard-grid-orders').baseParams.chart = null;
        Ext.getCmp('tcbillboard-grid-orders').getBottomToolbar().changePage(1);
        this.ChartT();
    },
});
Ext.reg('tcbillboard-form-orders', tcBillboard.panel.OrdersForm);
