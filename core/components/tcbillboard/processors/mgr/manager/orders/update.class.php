<?php

class tcBillboardOrdersUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'tcBillboardOrders';
    public $languageTopics = array('tcbillboard:default');
    //public $beforeSaveEvent = 'msOnBeforeUpdateOrder';
    public $afterSaveEvent = 'tcBillboardAfterCancelOrder';
    //public $permission = 'msorder_save';
    protected $status;
    protected $payment;
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
     * @return bool|null|string
     */
    public function beforeSet()
    {
        foreach (array('status', 'payment') as $v) {
            $this->$v = $this->object->get($v);
            if (!$this->getProperty($v)) {
                $this->addFieldError($v, $this->modx->lexicon('tcbillboard_err_ns'));
            }
        }

        if ($status = $this->modx->getObject('tcBillboardStatus')) {
            if ($status->get('final')) {
                return $this->modx->lexicon('ms2_err_status_final');
            }
        }

        return parent::beforeSet();
    }


    /**
     * @return bool|string
     */
    public function beforeSave()
    {
        $status = $this->object->get('status');
        if ($status != $this->status) {
            if ($status == 2) {
                $this->object->set('paymentdate', time());
            } elseif ($status == 3) {
                $this->object->set('unpubdatedon', time());
            }
        }
        return parent::beforeSave();
    }


    /**
     * @return bool
     */
    public function afterSave()
    {
        $status = $this->object->get('status');
        if ($status != $this->status) {
            $this->tcBillboard->changeStatusEmail($this->object->toArray());
            if ($status == 3) {
                $response = $this->tcBillboard->runProcessor('resource/unpublish',
                    array('id' => $this->object->get('res_id')));
                if ($response->isError()) {
                    $this->modx->log(modX::LOG_LEVEL_ERROR, 'tcBillboard: ' . $response->getMessage());
                }
            }
        }
        return parent::afterSave();
    }
}

return 'tcBillboardOrdersUpdateProcessor';