<?php

class tcBillboardStatusRemoveProcessor extends modObjectProcessor
{
    /** @var msOrderStatus $object */
    public $object;
    public $classKey = 'tcBillboardStatus';
    public $languageTopics = array('tcbillboard');
    public $permission = 'tbsetting_remove';


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

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('tcbillboard_err_status_ns'));
        }

        foreach ($ids as $id) {
            /** @var tcBillboardItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('tcbillboard_err_status_nf'));
            }
            $object->remove();
        }
        return $this->success();
    }

}
return 'tcBillboardStatusRemoveProcessor';