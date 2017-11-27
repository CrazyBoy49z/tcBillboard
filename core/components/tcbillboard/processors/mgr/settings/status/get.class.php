<?php

class tcBillboardStatusGetProcessor extends modObjectGetProcessor
{
    /** @var tcBillboardStatus $object */
    public $object;
    public $classKey = 'tcBillboardStatus';
    public $languageTopics = array('tcbillboard');
    //public $permission = 'view';



    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }
        return parent::initialize();
    }
}

return 'tcBillboardStatusGetProcessor';