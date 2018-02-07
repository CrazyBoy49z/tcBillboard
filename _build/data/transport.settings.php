<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'limit_introtext' => array(
        'xtype' => 'numberfield',
        'value' => 200,
        'area' => 'tcbillboard_main',
    ),
    'source_default' => array(
        'xtype' => 'modx-combo-source',
        'value' => 0,
        'area' => 'tcbillboard_main',
    ),
    'date_formate' => array(
        'xtype' => 'textfield',
        'value' => 'd.m.Y',
        'area' => 'tcbillboard_main',
    ),
    'number_template' => array(
        'xtype' => 'textfield',
        'value' => 'RE-{Y-m}',
        'area' => 'tcbillboard_main',
    ),
    'to_zero' => array(
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => 'tcbillboard_main',
    ),
    'delete_day' => array(
        'xtype' => 'numberfield',
        'value' => 30,
        'area' => 'tcbillboard_main',
    ),
    'admin_logout_time' => array(
        'xtype' => 'numberfield',
        'value' => 0,
        'area' => 'tcbillboard_main',
    ),
    'files_limit' => array(
        'xtype' => 'numberfield',
        'value' => 12,
        'area' => 'tcbillboard_main',
    ),
    'penalty_activate' => array(
        'xtype' => 'combo-boolean',
        'value' => false,
        'area' => 'tcbillboard_main',
    ),
    'resource_form' => array(
        'xtype' => 'numberfield',
        'value' => '',
        'area' => 'tcbillboard_main',
    ),
    'stock_template' => array(
        'xtype' => 'numberfield',
        'value' => '',
        'area' => 'tcbillboard_main',
    ),
    'payment_template' => array(
        'xtype' => 'numberfield',
        'value' => '',
        'area' => 'tcbillboard_main',
    ),

    'google_api_key' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'tcbillboard_google_map',
    ),
    'google_map_zoom' => array(
        'xtype' => 'numberfield',
        'value' => 17,
        'area' => 'tcbillboard_google_map',
    ),
    'google_map_latitude' => array(
        'xtype' => 'numberfield',
        'value' => 52.5200066,
        'area' => 'tcbillboard_google_map',
    ),
    'google_map_longitude' => array(
        'xtype' => 'numberfield',
        'value' => 13.40392403,
        'area' => 'tcbillboard_google_map',
    ),

    'bank_transfer_name' => array(
        'xtype' => 'textfield',
        'value' => 'Commerzbank',
        'area' => 'tcbillboard_bank_transfer',
    ),
    'bank_transfer_iban' => array(
        'xtype' => 'textfield',
        'value' => 'DE86 3704 0044 0423 6949 00',
        'area' => 'tcbillboard_bank_transfer',
    ),
    'bank_transfer_bic' => array(
        'xtype' => 'textfield',
        'value' => 'COBADEFFXXX',
        'area' => 'tcbillboard_bank_transfer',
    ),

    'paypal_currency' => array(
        'xtype' => 'textfield',
        'value' => 'EUR',
        'area' => 'tcbillboard_paypal',
    ),
    'paypal_key_sandbox' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'tcbillboard_paypal',
    ),
    'paypal_key_production' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'tcbillboard_paypal',
    ),

    'email_sender' => array(
        'xtype' => 'textfield',
        'value' => 'rechnung@saisonverkauf.info',
        'area' => 'tcbillboard_email',
    ),
    'email_subject' => array(
        'xtype' => 'textfield',
        'value' => 'Ihre Saisonverkauf Info Rechnung',
        'area' => 'tcbillboard_email',
    ),
    'email_to_manager' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'tcbillboard_email',
    ),

    'import_csv_text' => array(
        'xtype' => 'textfield',
        'value' => 'Buchungstext',
        'area' => 'tcbillboard_import_csv',
    ),
    'import_csv_amount' => array(
        'xtype' => 'textfield',
        'value' => 'Betrag',
        'area' => 'tcbillboard_import_csv',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'tcbillboard_' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
