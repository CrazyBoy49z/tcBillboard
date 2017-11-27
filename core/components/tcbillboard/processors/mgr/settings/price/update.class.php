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

        if (empty($id)) {
            return $this->modx->lexicon('tcbillboard_err_price_ns');
        }

        if (empty($period)) {
            $this->modx->error->addField('period', $this->modx->lexicon('tcbillboard_err_period'));
        } elseif ($this->modx->getCount($this->classKey, array('period' => $period, 'id:!=' => $id))) {
            $this->modx->error->addField('price', $this->modx->lexicon('tcbillboard_err_period_ae'));
        } elseif (empty($price)) {
            $this->modx->error->addField('price', $this->modx->lexicon('tcbillboard_err_price'));
        }

        return parent::beforeSet();
    }
}

return 'tcBillboardPriceUpdateProcessor';
