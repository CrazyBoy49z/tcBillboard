<?php

class tcBillboardItemRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'tcBillboardItem';
    public $classKey = 'tcBillboardItem';
    public $languageTopics = array('tcbillboard');
    //public $permission = 'remove';


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
            return $this->failure($this->modx->lexicon('tcbillboard_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var tcBillboardItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('tcbillboard_item_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'tcBillboardItemRemoveProcessor';