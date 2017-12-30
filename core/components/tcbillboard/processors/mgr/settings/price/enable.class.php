<?php

class tcBillboardPriceEnableProcessor extends modObjectProcessor
{
    public $classKey = 'tcBillboardPrice';
    public $languageTopics = array('tcbillboard');


    /**
     * @return array|string
     */
    public function process()
    {
        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('tcbillboard_err_price_ns'));
        }

        foreach ($ids as $id) {
            /** @var tcBillboardItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('tcbillboard_err_price_nf'));
            }
            $object->set('active', true);
            $object->save();
        }
        return $this->success();
    }

}
return 'tcBillboardPriceEnableProcessor';
