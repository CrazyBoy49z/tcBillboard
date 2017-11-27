<?php

class tcBillboardItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'tcBillboardItem';
    public $classKey = 'tcBillboardItem';
    public $languageTopics = array('tcbillboard');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('tcbillboard_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('tcbillboard_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'tcBillboardItemCreateProcessor';