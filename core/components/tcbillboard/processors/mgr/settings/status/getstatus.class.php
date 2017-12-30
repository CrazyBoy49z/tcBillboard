<?php

class tcBillboardGetStatusGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'tcBillboardStatus';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'asc';

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        if ($id = (int)$this->getProperty('id')) {
            $c->where(array('id' => $id));
        }
        if ($query = trim($this->getProperty('query'))) {
            $c->where(array('name:LIKE' => "%{$query}%"));
        }
        return $c;
    }

}
return 'tcBillboardGetStatusGetListProcessor';