<?php

class tcBillboardStatusCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'tcBillboardStatus';
    public $languageTopics = array('tcbillboard');


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('tcbillboard_err_status_name'));
        } elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('tcbillboard_err_status_ae'));
        }
        return parent::beforeSet();
    }

}
return 'tcBillboardStatusCreateProcessor';