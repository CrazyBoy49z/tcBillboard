<?php

class tcBillboardPaymentGetProcessor extends modObjectGetProcessor
{
    public $classKey = 'tcBillboardPayment';
    public $languageTopics = array('tcbillboard');
    public $permission = 'tbsetting_view';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return mixed
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        return parent::process();
    }

}
return 'tcBillboardPaymentGetProcessor';