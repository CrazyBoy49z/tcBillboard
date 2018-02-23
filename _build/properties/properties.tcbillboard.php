<?php

$properties = array();

$tmp = array(
    'tpl' => array(
        'type' => 'textfield',
        'value' => 'tcBillboardMyOrdersTpl',
    ),
    'tplWrapper' => array(
        'type' => 'textfield',
        'value' => 'tcbillboardMyOrdersWrapperTpl',
    ),
    'user' => array(
        'type' => 'numberfield',
        'value' => '',
    ),
    'sortby' => array(
        'type' => 'textfield',
        'value' => 'DESC',
    ),
    'fields' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'pagination' => array(
        'type' => 'combo-boolean',
        'value' => true,
    ),
);

foreach ($tmp as $k => $v) {
    $properties[] = array_merge(
        array(
            'name' => $k,
            'desc' => PKG_NAME_LOWER . '_prop_' . $k,
            'lexicon' => PKG_NAME_LOWER . ':properties',
        ), $v
    );
}

return $properties;