<?php

class tcBillboardPenaltyEnableProcessor extends modObjectProcessor
{
    public $classKey = 'tcBillboardPenalty';
    public $languageTopics = array('tcbillboard');


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
            return $this->failure($this->modx->lexicon('tcbillboard_err_penalty_ns'));
        }

        foreach ($ids as $id) {
            /** @var tcBillboardPenalty $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('tcbillboard_err_penalty_nf'));
            }
            $object->set('active', true);
            $object->save();
        }
        return $this->success();
    }
}
return 'tcBillboardPenaltyEnableProcessor';
