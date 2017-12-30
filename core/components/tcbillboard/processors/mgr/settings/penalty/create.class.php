<?php

class tcBillboardPenaltyCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'tcBillboardPenalty';
    public $languageTopics = array('tcbillboard');


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $days = trim($this->getProperty('days'));
        $formula = 'incasso';

        $percent = trim(str_replace(',', '.', $this->getProperty('percent')));
        $fine = trim(str_replace(',', '.', $this->getProperty('fine')));

        if ($percent || $fine) {
            $formula = '*' . $percent / 100 . '+' . $fine;
        }

        $this->setProperty('formula', $formula);

        if (empty($days)) {
            $this->modx->error->addField('days', $this->modx->lexicon('tcbillboard_err_amount_days'));
        } elseif ($this->modx->getCount($this->classKey, array('days' => $days))) {
            $this->modx->error->addField('days', $this->modx->lexicon('tcbillboard_err_amount_days_ae'));
        }
        return parent::beforeSet();
    }
}
return 'tcBillboardPenaltyCreateProcessor';