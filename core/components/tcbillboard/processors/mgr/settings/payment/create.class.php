<?php

class tcBillboardPaymentCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'tcBillboardPayment';
    public $languageTopics = array('tcbillboard');


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('tcbillboard_err_payment_name'));
        } elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('tcbillboard_err_payment_ae'));
        }
        return parent::beforeSet();
    }

}
return 'tcBillboardPaymentCreateProcessor';