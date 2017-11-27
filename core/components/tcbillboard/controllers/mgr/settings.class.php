<?php

/**
 * The home manager controller for tcBillboard.
 *
 */
class tcBillboardMgrSettingsManagerController extends modExtraManagerController
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
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/misc/combo.js');

        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/settings/settings.panel.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/settings/status/status.grid.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/settings/price/price.grid.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/settings/payment/payment.grid.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/settings/penalty/penalty.grid.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/settings/widgets/settings.windows.js');

        /*
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->tcBillboard->config['jsUrl'] . 'mgr/sections/home.js');*/

        $this->addHtml('<script type="text/javascript">
        tcBillboard.config = ' . json_encode($this->tcBillboard->config) . ';
        tcBillboard.config.connector_url = "' . $this->tcBillboard->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.add({ xtype: "tcbillboard-panel-settings"});
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