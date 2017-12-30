<?php

class tcBillboardPenaltyGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'tcBillboardPenalty';
    public $defaultSortField = 'days';
    public $defaultSortDirection = 'ASC';
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
            'title' => $this->modx->lexicon('tcbillboard_penalty_update'),
            'action' => 'updatePenalty',
            'button' => true,
            'menu' => true,
        );

        if (!$array['active']) {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('tcbillboard_item_enable'),
                'multiple' => $this->modx->lexicon('tcbillboard_items_enable'),
                'action' => 'enablePenalty',
                'button' => true,
                'menu' => true,
            );
        } else {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('tcbillboard_item_disable'),
                'multiple' => $this->modx->lexicon('tcbillboard_items_disable'),
                'action' => 'disablePenalty',
                'button' => true,
                'menu' => true,
            );
        }

        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('tcbillboard_penalty_remove'),
            'multiple' => $this->modx->lexicon('tcbillboard_penalties_remove'),
            'action' => 'removePenalty',
            'button' => true,
            'menu' => true,
        );
        return $array;
    }
}
return 'tcBillboardPenaltyGetListProcessor';