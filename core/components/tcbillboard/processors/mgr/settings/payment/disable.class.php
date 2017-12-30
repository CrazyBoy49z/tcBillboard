<?php

class tcBillboardPaymentDisableProcessor extends modObjectProcessor
{
    public $classKey = 'tcBillboardPayment';
    public $languageTopics = array('tcbillboard');


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
            return $this->failure($this->modx->lexicon('tcbillboard_err_payment_ns'));
        }

        foreach ($ids as $id) {
            /** @var tcBillboardItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('tcbillboard_err_payment_nf'));
            }

            $object->set('active', false);
            $object->save();
        }

        return $this->success();
    }

}
return 'tcBillboardPaymentDisableProcessor';
