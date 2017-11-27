<?php

class tcBillboardPenaltyUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'tcBillboardPenalty';
    public $languageTopics = array('tcbillboard');
    //public $permission = 'save';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->getProperty('id');
        $days = trim($this->getProperty('days'));
        $formula = 'incasso';


        $percent = trim(str_replace(',', '.', $this->getProperty('percent')));
        $fine = trim(str_replace(',', '.', $this->getProperty('fine')));

        if ($percent || $fine) {
            $formula = '*' . $percent / 100 . '+' . $fine;
        }

        $this->setProperty('formula', $formula);

        if (empty($id)) {
            return $this->modx->lexicon('tcbillboard_err_penalty_ns');
        }

        if (empty($days)) {
            $this->modx->error->addField('days', $this->modx->lexicon('tcbillboard_err_amount_days'));
        } elseif ($this->modx->getCount($this->classKey, array('days' => $days, 'id:!=' => $id))) {
            $this->modx->error->addField('days', $this->modx->lexicon('tcbillboard_err_amount_days_ae'));
        }

        return parent::beforeSet();
    }
}

return 'tcBillboardPenaltyUpdateProcessor';
