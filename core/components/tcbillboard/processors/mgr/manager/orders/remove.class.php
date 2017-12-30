<?php

class tcBillboardOrdersRemoveProcessor extends modObjectProcessor
{
    public $classKey = 'tcBillboardOrders';
    public $languageTopics = array('tcbillboard');
    public $permission = 'tborder_remove';

    /** @var  tcBillboard $tcBillboard */
    protected $tcBillboard;


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        $this->tcBillboard = $this->modx->getService('tcBillboard');

        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }
        return parent::initialize();
    }

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('tcbillboard_err_order_ns'));
        }

        foreach ($ids as $id) {
            /** @var tcBillboardOrders $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('tcbillboard_err_order_nf'));
            }

            $resId = $object->get('res_id');
            $pathTickets = MODX_ASSETS_PATH . 'images/tickets/' . $resId . '/';
            $pathTcBillboard = MODX_ASSETS_PATH . 'images/tcbillboard/' . $resId . '/';
            if (file_exists($pathTickets)) {
                $this->tcBillboard->removeDir($pathTickets);
            }
            if (file_exists($pathTcBillboard)) {
                $this->tcBillboard->removeDir($pathTcBillboard);
            }

            $object->remove();
        }
        return $this->success();
    }

}

return 'tcBillboardOrdersRemoveProcessor';