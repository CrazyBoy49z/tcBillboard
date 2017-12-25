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
        $graceperiodStart = date('Y-m-d 00:00:00', strtotime($this->getProperty('graceperiod_start')));
        $graceperiodEnd = date('Y-m-d 00:00:00', strtotime($this->getProperty('graceperiod')));

        if (empty($period)) {
            $this->modx->error->addField('period', $this->modx->lexicon('tcbillboard_err_period'));
        } elseif ($this->modx->getCount($this->classKey, array('period' => $period))) {
            $this->modx->error->addField('period', $this->modx->lexicon('tcbillboard_err_period_ae'));
        } elseif (empty($price)) {
            $this->modx->error->addField('price', $this->modx->lexicon('tcbillboard_err_price'));
        } else if ($graceperiodStart >= $graceperiodEnd) {
            $this->modx->error->addField('graceperiod_start', '');
            $this->modx->error->addField('graceperiod', '');
            return $this->modx->lexicon('tcbillboard_err_graceperiod_start');
        }

        return parent::beforeSet();
    }
}

return 'tcBillboardPriceCreateProcessor';