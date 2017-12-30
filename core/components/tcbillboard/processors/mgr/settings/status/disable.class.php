<?php

class tcBillboardStatusDisableProcessor extends modObjectProcessor
{
    public $classKey = 'tcBillboardStatus';
    public $languageTopics = array('tcbillboard');


    /**
     * @return array|string
     */
    public function process()
    {
        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('tcbillboard_err_status_ns'));
        }

        foreach ($ids as $id) {
            /** @var tcBillboardItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('tcbillboard_err_status_nf'));
            }
            $object->set('active', false);
            $object->save();
        }
        return $this->success();
    }

}
return 'tcBillboardStatusDisableProcessor';
