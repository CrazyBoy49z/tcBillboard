<?php

class tcBillboardPenaltyGetProcessor extends modObjectGetProcessor
{
    public $classKey = 'tcBillboardPenalty';
    public $languageTopics = array('tcbillboard:default');
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
return 'tcBillboardPenaltyGetProcessor';