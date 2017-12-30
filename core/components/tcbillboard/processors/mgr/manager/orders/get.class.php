<?php

class tcBillboardOrdersGetProcessor extends modObjectGetProcessor
{
    public $classKey = 'tcBillboardOrders';
    public $languageTopics = array('tcbillboard:default');
    public $permission = 'tborder_view';


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

return 'tcBillboardOrdersGetProcessor';