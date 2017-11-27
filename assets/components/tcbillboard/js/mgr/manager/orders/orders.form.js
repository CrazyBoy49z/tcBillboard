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
                columnWidth: .57,
                layout: 'form',
                items: [{
                    // html: '<div id="tcbillboard-chart"></div>',
                    // //id: 'tcbillboard-chart',
                    // listeners: {
                    //     // render: {
                    //     //     fn: function(a,b,c,d,e,f) {
                    //     //         this.setup(config);
                    //     //
                    //     //         console.log(a,b,c,d,e,f);
                    //     //     }, scope: this
                    //     // }
                    //     afterlayout: {
                    //         fn: function () {
                    //             this.setup(config.dataset);
                    //         }, scope: this
                    //     },
                    //     single: true
                    // }
                    html: '<div id="tcbillboard-chart"></div>',
                    //id: 'tcbillboard-chart-orders',
                    //xtype: 'tcbillboard-chart-orders',
                    listeners: {
                        afterlayout: {
                            fn: function(dateField, dateObject) {
                                //this.tcBillboardChart(config);
                                //google.charts.load("current", {packages:["corechart"]});
                                //tcBillboard.drawChart();
                                this.getEl().on('click', function() {
                                    this.fireEvent('change');
                                    setTimeout(function() {
                                        var value = Ext.getCmp(config.id + '-chart').getValue();

                                        Ext.getCmp('tcbillboard-grid-orders').baseParams.chart = value;
                                        Ext.getCmp('tcbillboard-grid-orders').getBottomToolbar().changePage(1);
                                        Ext.getCmp('tcbillboard-grid-orders').refresh();
                                    }, 300);
                                }, this);
                            }
                        },
                        single: true
                    }
                }]
            },{
                columnWidth: .1,
                layout: 'form',
                hidden: true,
                items: [{
                    xtype: 'textfield',
                    name: 'chart',
                    id: config.id + '-chart',
                }]
            }]
        },{
            // xtype: 'panel',
            // cls: 'button-holder',
            // items: [{
            //     xtype: 'button',
            //     text: '<i class="icon icon-times"></i> ' + _('tcbillboard_reset'),
            //     scope: this,
            //     cls: 'btn',
            //     iconCls: 'x-btn-small',
            //     handler: this.reset
            //}]
        }]
    });
    tcBillboard.panel.OrdersForm.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard.panel.OrdersForm, MODx.FormPanel, {

    // drawChart: function() {
    //     // google.charts.load("current", {packages: ["corechart"]});
    //     // google.charts.setOnLoadCallback(drawChart);
    //
    //     //function drawChart() {
    //         var data = google.visualization.arrayToDataTable([
    //             ['Element', 'Доля', {role: 'style'}, 'value'],
    //             ['PayPal ', tcBillboard.config.payment.PayPal, 'gold', 2],
    //             ['Банковский перевод ', tcBillboard.config.payment.bank, 'color: #e5e4e2', 1]
    //         ]);
    //
    //         var view = new google.visualization.DataView(data);
    //         view.setColumns([0, 1,
    //             {
    //                 calc: "stringify",
    //                 sourceColumn: 1,
    //                 type: "string",
    //                 role: "annotation"
    //             },
    //             2]);
    //
    //         var options = {
    //             title: "Доля способов оплаты",
    //             //width: 600,
    //             height: 120,
    //             bar: {groupWidth: "85%"},
    //             legend: {position: "none"},
    //             //isStacked: 'percent',
    //             hAxis: {
    //                 minValue: 0,
    //                 //ticks: [0, .3, .6, .9, 1]
    //             }
    //         };
    //         var chart = new google.visualization.BarChart(document.getElementById("tcbillboard-chart"));
    //         chart.draw(view, options);
    //
    //         google.visualization.events.addListener(chart, 'select', function () {
    //             var selection = chart.getSelection();
    //             if (selection.length) {
    //                 var row = selection[0].row;
    //                 var value = data.getValue(row, 3);
    //
    //                 document.querySelector('#tcbillboard-form-orders-chart').value = data.getValue(row, 3);
    //                 document.getElementById('tcbillboard-form-orders-chart').click();
    //             }
    //         });
    //     //}
    // },

    setup: function(dataset) {
        // var colors = {
        //     time: '#68DBF2'
        //     , create: '#87B953'
        //     , update: '#8D3EA2'
        //     , error: '#F05D5E'
        // };
        var container = Ext.get('tcbillboard-chart');
        Ext.DomHelper.append(container, {tag: 'div', id: 'tcbillboard-chart-other'});

        //console.log(container);
    },

    getButtons: function () {
        return [{
            text: '<i class="icon icon-times"></i> ' + _('tcbillboard_reset'),
            handler: this.reset,
            scope: this,
            cls: 'btn',
            iconCls: 'x-btn-small'
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
        Ext.getCmp('tcbillboard-grid-orders').getBottomToolbar().changePage(1);
    },
});
Ext.reg('tcbillboard-form-orders', tcBillboard.panel.OrdersForm);
