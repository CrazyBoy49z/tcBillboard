<?php

class tcBillboardPriceCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'tcBillboardPrice';
    public $languageTopics = array('tcbillboard');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $period = trim($this->getProperty('period'));
        $price = (float)$this->getProperty('price');

        if (empty($period)) {
            $this->modx->error->addField('period', $this->modx->lexicon('tcbillboard_err_period'));
        } elseif ($this->modx->getCount($this->classKey, array('period' => $period))) {
            $this->modx->error->addField('period', $this->modx->lexicon('tcbillboard_err_period_ae'));
        } elseif (empty($price)) {
            $this->modx->error->addField('price', $this->modx->lexicon('tcbillboard_err_price'));
        }

        return parent::beforeSet();
    }
}

return 'tcBillboardPriceCreateProcessor';