<?php

class tcBillboardPaymentGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'tcBillboardPayment';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'asc';
    public $permission = 'tbsetting_list';


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
     * @return array|mixed|string
     */
    public function process() {
        $beforeQuery = $this->beforeQuery();
        if ($beforeQuery !== true) {
            return $this->failure($beforeQuery);
        }
        $data = $this->getData();
        $list = $this->iterate($data);

        return $this->outputArray($list,$data['total']);
    }

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        if ($this->getProperty('combo')) {
            $c->select('id,name');
            $c->where(array('active' => 1));
        }

        if ($query = trim($this->getProperty('query'))) {
            $c->where(array(
                'name:LIKE' => "%{$query}%",
                'OR:description:LIKE' => "%{$query}%",
                'OR:class:LIKE' => "%{$query}%",
            ));
        }
        return $c;
    }

    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $data = $object->toArray();
        $data['actions'] = array();

        $data['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('tcbillboard_update'),
            'action' => 'updatePayment',
            'button' => true,
            'menu' => true,
        );
        if (empty($data['active'])) {
            $data['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('tcbillboard_enable'),
                'multiple' => $this->modx->lexicon('tcbillboard_enable'),
                'action' => 'enablePayment',
                'button' => true,
                'menu' => true,
            );
        } else {
            $data['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('tcbillboard_disable'),
                'multiple' => $this->modx->lexicon('tcbillboard_disable'),
                'action' => 'disablePayment',
                'button' => true,
                'menu' => true,
            );
        }
        if ($data['editable']) {
            $data['actions'][] = array(
                'cls' => array(
                    'menu' => 'red',
                    'button' => 'red',
                ),
                'icon' => 'icon icon-trash-o',
                'title' => $this->modx->lexicon('tcbillboard_remove'),
                'multiple' => $this->modx->lexicon('tcbillboard_multiple_remove'),
                'action' => 'removePayment',
                'button' => true,
                'menu' => true,
            );
        }
        return $data;
    }

}
return 'tcBillboardPaymentGetListProcessor';