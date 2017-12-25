<?php

class tcBillboardPriceUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'tcBillboardPrice';
    public $languageTopics = array('tcbillboard');
    //public $permission = 'save';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->getProperty('id');
        $period = trim($this->getProperty('period'));
        $price = (float)$this->getProperty('price');
        $graceperiodStart = date('Y-m-d 00:00:00', strtotime($this->getProperty('graceperiod_start')));
        $graceperiodEnd = date('Y-m-d 00:00:00', strtotime($this->getProperty('graceperiod')));
        //$time = time();

        if (empty($id)) {
            return $this->modx->lexicon('tcbillboard_err_price_ns');
        }

        if (!$this->getProperty('graceperiod_start')) {
            $this->setProperty('graceperiod_start', null);
        }
        if (!$this->getProperty('graceperiod')) {
            $this->setProperty('graceperiod', null);
        }

        if (empty($period)) {
            $this->modx->error->addField('period', $this->modx->lexicon('tcbillboard_err_period'));
        } elseif ($this->modx->getCount($this->classKey, array('period' => $period, 'id:!=' => $id))) {
            $this->modx->error->addField('period', $this->modx->lexicon('tcbillboard_err_period_ae'));
        } elseif (empty($price)) {
            $this->modx->error->addField('price', $this->modx->lexicon('tcbillboard_err_price'));
        } else if ($graceperiodStart > $graceperiodEnd) {
            $this->modx->error->addField('graceperiod_start', '');
            $this->modx->error->addField('graceperiod', '');
            return $this->modx->lexicon('tcbillboard_err_graceperiod_start');
        }
        return parent::beforeSet();
    }
}

return 'tcBillboardPriceUpdateProcessor';
