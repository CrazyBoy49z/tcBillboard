<?php

class tcBillboardPriceGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'tcBillboardPrice';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'asc';
    public $permission = 'tbsetting_list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }
        return true;
    }

    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = array();

        // Edit
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('tcbillboard_price_update'),
            'action' => 'updatePrice',
            'button' => true,
            'menu' => true,
        );

        if (!$array['active']) {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('tcbillboard_price_enable'),
                'multiple' => $this->modx->lexicon('tcbillboard_prices_enable'),
                'action' => 'enablePrice',
                'button' => true,
                'menu' => true,
            );
        } else {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('tcbillboard_price_disable'),
                'multiple' => $this->modx->lexicon('tcbillboard_prices_disable'),
                'action' => 'disablePrice',
                'button' => true,
                'menu' => true,
            );
        }

        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('tcbillboard_price_remove'),
            'multiple' => $this->modx->lexicon('tcbillboard_prices_remove'),
            'action' => 'removePrice',
            'button' => true,
            'menu' => true,
        );
        return $array;
    }

}
return 'tcBillboardPriceGetListProcessor';