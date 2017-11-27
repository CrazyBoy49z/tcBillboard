var tcBillboard = function (config) {
    config = config || {};
    tcBillboard.superclass.constructor.call(this, config);
};
Ext.extend(tcBillboard, Ext.Component, {
    //page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {},
    //view: {}, utils: {}
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {},
    view: {}, keymap: {}, plugin: {}, utils: {}, chart: {}
});
Ext.reg('tcbillboard', tcBillboard);

tcBillboard = new tcBillboard();