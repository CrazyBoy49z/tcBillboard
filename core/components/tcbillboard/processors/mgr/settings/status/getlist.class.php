<?php

class tcBillboardStatusGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'tcBillboardStatus';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'asc';
    //public $permission = 'mssetting_list';


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
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        if ($query = trim($this->getProperty('query'))) {
            $c->where(array(
                'name:LIKE' => "%{$query}%",
                'OR:description:LIKE' => "%{$query}%",
            ));
        }

//        print_r($this->getProperties());
//        die;

        if ($this->getProperty('combo')) {
            $c->select('id, name');
            $c->where(array('active' => 1));

            if ($order_id = $this->getProperty('order_id')) {
                /** @var tcBillboardOrders $order */
                /** @var tcBillboardStatus $status */
                if ($order = $this->modx->getObject('tcBillboardOrders', $order_id) AND $status = $order->getOne('Status')) {
                    if ($status->get('final')) {
                        $c->where(array('id' => $status->get('id')));
                    } elseif ($status->get('fixed')) {
                        $c->where(array('rank:>=' => $status->get('rank')));
                    }
                }
            }
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
        if ($this->getProperty('combo')) {
            $data = array(
                'id' => $object->get('id'),
                'name' => $object->get('name'),
            );
        } else {
            $data = $object->toArray();
            if (!$data['chunk_user']) {
                $data['chunk_user'] = null;
            }
            if (!$data['chunk_manager']) {
                $data['chunk_manager'] = null;
            }
            $data['actions'] = array();

            $data['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-edit',
                'title' => $this->modx->lexicon('tcbillboard_update'),
                'action' => 'updateStatus',
                'button' => true,
                'menu' => true,
            );

            if (empty($data['active'])) {
                $data['actions'][] = array(
                    'cls' => '',
                    'icon' => 'icon icon-power-off action-green',
                    'title' => $this->modx->lexicon('tcbillboard_enable'),
                    'multiple' => $this->modx->lexicon('tcbillboard_enable'),
                    'action' => 'enableStatus',
                    'button' => true,
                    'menu' => true,
                );
            } else {
                $data['actions'][] = array(
                    'cls' => '',
                    'icon' => 'icon icon-power-off action-gray',
                    'title' => $this->modx->lexicon('tcbillboard_disable'),
                    'multiple' => $this->modx->lexicon('tcbillboard_disable'),
                    'action' => 'disableStatus',
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
                    'action' => 'removeStatus',
                    'button' => true,
                    'menu' => true,
                );
            }
        }

        return $data;
    }


    /**
     * @param array $array
     * @param bool $count
     *
     * @return string
     */
    public function outputArray(array $array, $count = false)
    {
        if ($this->getProperty('addall')) {
            $array = array_merge_recursive(array(
                array(
                    'id' => 0,
                    'name' => $this->modx->lexicon('tcbillboard_all'),
                ),
            ), $array);
        }

        return parent::outputArray($array, $count);
    }

}

return 'tcBillboardStatusGetListProcessor';