<?php

$properties = array();

$tmp = array(
    'allowedFields' => array(
        'type' => 'textfield',
        'value' => 'parent,pagetitle,content,pub_date,unpub_date',
    ),
    'requiredFields' => array(
        'type' => 'textfield',
        'value' => 'parent,pagetitle,content,pub_date,unpub_date,payment',
    ),
    'tplFormCreate' => array(
        'type' => 'textfield',
        'value' => 'tcBillboardFormCreateTpl',
    ),
    'tplPreview' => array(
        'type' => 'textfield',
        'value' => 'tcBillboardFormPreviewTpl',
    ),
    'tplImage' => array(
        'type' => 'textfield',
        'value' => 'tcBillboardImageTpl',
    ),
    'tplScore' => array(
        'type' => 'textfield',
        'value' => 'tcBillboardScoreTpl',
    ),
    'tplInvoiceNew' => array(
        'type' => 'textfield',
        'value' => 'tcBillboardEmailInvoiceTpl',
    ),
    'tplInvoiceNewPdf' => array(
        'type' => 'textfield',
        'value' => 'tcBillboardEmailInvoiceNewPdfTpl'
    ),
    'tplSuccessBank' => array(
        'type' => 'textfield',
        'value' => 'tcBillboardSuccessBankTpl',
    ),
    'tplSuccessPayPal' => array(
        'type' => 'textfield',
        'value' => 'tcBillboardSuccessPayPalTpl',
    ),
    'frontedCss' => array(
        'type' => 'textfield',
        'value' => 'components/tcbillboard/css/web/tcbillboard.css',
    ),
    'frontendJsFile' => array(
        'type' => 'textfield',
        'value' => 'components/tcbillboard/js/web/tcbillboardfile.js',
    ),
    'frontendJs' => array(
        'type' => 'textfield',
        'value' => 'components/tcbillboard/js/web/tcbillboard.js',
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