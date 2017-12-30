<?php

class tcBillboardStatusUpdateProcessor extends modObjectUpdateProcessor
{
    /** @var msOrderStatus $object */
    public $object;
    public $classKey = 'tcBillboardStatus';
    public $languageTopics = array('tcbillboard');
    public $permission = 'tbsetting_save';


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
     * @return bool
     */
    public function beforeSet()
    {
        $required = array('name');
        if ($this->getProperty('email_user')) {
            $required[] = 'subject_user';
            $required[] = 'chunk_user';
        }
        if ($this->getProperty('email_manager')) {
            $required[] = 'subject_manager';
            $required[] = 'chunk_manager';
        }
        foreach ($required as $field) {
            if (!$tmp = trim($this->getProperty($field))) {
                $this->addFieldError($field, $this->modx->lexicon('field_required'));
            } else {
                $this->setProperty($field, $tmp);
            }
        }
        $name = $this->getProperty('name');
        if ($this->modx->getCount($this->classKey, array('name' => $name, 'id:!=' => $this->object->id))) {
            $this->modx->error->addField('name', $this->modx->lexicon('tcbillboard_err_ae'));
        }
        return !$this->hasErrors();
    }

}
return 'tcBillboardStatusUpdateProcessor';