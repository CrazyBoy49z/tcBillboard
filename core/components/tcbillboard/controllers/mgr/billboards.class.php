<?php

/**
 * The home manager controller for tcBillboard.
 *
 */
class tcBillboardMgrBillboardsManagerController extends modExtraManagerController
{
    /** @var tcBillboard $tcBillboard */
    public $tcBillboard;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('tcbillboard_core_path', null,
                $this->modx->getOption('core_path') . 'components/tcbillboard/') . 'model/tcbillboard/';
        $this->tcBillboard = $this->modx->getService('tcbillboard', 'tcBillboard', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('tcbillboard:default');
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('tcbillboard');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->tcBillboard->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->tcBillboard->config['cssUrl'] . 'mgr/bootstrap.buttons.css');

        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/tcbillboard.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/misc/default.window.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/misc/combo.js');

        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/manager.panel.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/orders/orders.form.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/orders/orders.grid.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/orders/order.grid.details.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/widgets/orders.windows.js');

        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/invoice/invoice.form.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/invoice/invoice.grid.js');

        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/warning/warning.form.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/warning/warning.grid.js');

        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/vendor/highstock/highcharts.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/vendor/highstock/modules/data.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/vendor/highstock/modules/drilldown.js');

        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/manager/import/import.form.js');

        $percentages = $this->tcBillboard->getAverageOrders();

        $this->addHtml('<script type="text/javascript">
        tcBillboard.config = ' . json_encode($this->tcBillboard->config) . ';
        tcBillboard.config.connector_url = "' . $this->tcBillboard->config['connectorUrl'] . '";
        tcBillboard.config.payment = ' . $percentages . ';
        Ext.onReady(function() {
            MODx.add({ xtype: "tcbillboard-panel-orders"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    /*public function getTemplateFile()
    {
        return $this->tcBillboard->config['templatesPath'] . 'home.tpl';
    }*/
}