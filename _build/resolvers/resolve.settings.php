<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('tcbillboard_core_path', null,
                    $modx->getOption('core_path') . 'components/tcbillboard/') . 'model/';
            $modx->addPackage('tcbillboard', $modelPath);
            $lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;
            $statuses = array(
                1 => array(
                    'name' => !$lang ? 'Новый' : 'New',
                    'color' => '000000',
                    'email_user' => 1,
                    'email_manager' => 1,
                    'subject_user' => '[[%tcbillboard_email_subject_new_user]]',
                    'subject_manager' => '[[%tcbillboard_email_subject_new_manager]]',
                    'chunk_user' => 'tcBillboardEmailNewUserTpl',
                    'chunk_manager' => 'tcBillboardEmailNewManagerTpl',
                    'final' => 0,
                ),
                2 => array(
                    'name' => !$lang ? 'Оплачен' : 'Paid',
                    'color' => '008000',
                    'email_user' => 1,
                    'email_manager' => 1,
                    'subject_user' => '[[%tcbillboard_email_subject_paid_user]]',
                    'subject_manager' => '[[%tcbillboard_email_subject_paid_manager]]',
                    'chunk_user' => 'tcBillboardEmailPaidUserTpl',
                    'chunk_manager' => 'tcBillboardEmailPaidManagerTpl',
                    'final' => 0,
                ),
                3 => array(
                    'name' => !$lang ? 'Отменён' : 'Cancelled',
                    'color' => '800000',
                    'email_user' => 1,
                    'email_manager' => 0,
                    'subject_user' => '[[%tcBillboard_email_subject_cancelled_user]]',
                    'subject_manager' => '',
                    'chunk_user' => 'tcBillboardEmailCancelledUserTpl',
                    'chunk_manager' => '',
                    'final' => 1,
                ),
            );
            foreach ($statuses as $id => $properties) {
                if (!$status = $modx->getCount('tcBillboardStatus', array('id' => $id))) {
                    $status = $modx->newObject('tcBillboardStatus', array_merge(array(
                        'editable' => 0,
                        'active' => 1,
                        'rank' => $id - 1,
                        'fixed' => 1,
                    ), $properties));
                    $status->set('id', $id);
                    /*@var modChunk $chunk */
                    if (!empty($properties['chunk_user'])) {
                        if ($chunk = $modx->getObject('modChunk', array('name' => $properties['chunk_user']))) {
                            $status->set('chunk_user', $chunk->get('id'));
                        }
                    }
                    if (!empty($properties['chunk_manager'])) {
                        if ($chunk = $modx->getObject('modChunk', array('name' => $properties['chunk_manager']))) {
                            $status->set('chunk_manager', $chunk->get('id'));
                        }
                    }
                    $status->save();
                }
            }
            /** @var tcBillboardOption $tcSettingsYear */
            if (!$tcSettingsYear = $modx->getObject('tcBillboardOption', array(
                'key' => 'tcbillboard_current_year',
            ))) {
                $tcSettingsYear = $modx->newObject('tcBillboardOption');
                $tcSettingsYear->fromArray(array(
                    'key' => 'tcbillboard_current_year',
                    'value' => date('Y'),
                ), '', true);
                $tcSettingsYear->save();
            }
            /** @var tcBillboardOption $tcSettingsNumber */
            if (!$tcSettingsNumber = $modx->getObject('tcBillboardOption', array(
                'key' => 'tcbillboard_order_number',
            ))) {
                $tcSettingsNumber = $modx->newObject('tcBillboardOption');
                $tcSettingsNumber->fromArray(array(
                    'key' => 'tcbillboard_order_number',
                    'value' => 0,
                ), '', true);
                $tcSettingsNumber->save();
            }
            /** @var tcBillboardPayment $payment */
            if (!$payment = $modx->getObject('tcBillboardPayment', 1)) {
                $payment = $modx->newObject('tcBillboardPayment');
                $payment->fromArray(array(
                    'id' => 1,
                    'name' => !$lang ? 'Банковский перевод' : 'Bank transfer',
                    'active' => 1,
                    'rank' => 0,
                ), '', true);
                $payment->save();
            }
            /** @var tcBillboardPayment $payment */
            if (!$payment = $modx->getObject('tcBillboardPayment', 2)) {
                $payment = $modx->newObject('tcBillboardPayment');
                $payment->fromArray(array(
                    'id' => 2,
                    'name' => 'PayPal',
                    'active' => 1,
                    'rank' => 1,
                ), '', true);
                $payment->save();
            }
            /** @var msDeliveryMember $member */
            /*if (!$member = $modx->getObject('msDeliveryMember', array('payment_id' => 1, 'delivery_id' => 1))) {
                $member = $modx->newObject('msDeliveryMember');
                $member->fromArray(array(
                    'payment_id' => 1,
                    'delivery_id' => 1,
                ), '', true);
                $member->save();
            }
            if ($setting = $modx->getObject('modSystemSetting', array('key' => 'ms2_order_product_fields'))) {
                $value = $setting->get('value');
                if (strpos($value, 'product_pagetitle') !== false) {
                    $value = str_replace('product_pagetitle', 'name', $value);
                    $setting->set('value', $value);
                    $setting->save();
                }
            }
            $old_settings = array(
                'ms2_category_remember_grid',
                'ms2_product_thumbnail_size',
            );
            foreach ($old_settings as $key) {
                if ($item = $modx->getObject('modSystemSetting', $key)) {
                    $item->remove();
                }
            }*/
            break;
        case xPDOTransport::ACTION_UNINSTALL:
            $modx->removeCollection('modSystemSetting', array(
                'namespace' => 'tcbillboard',
            ));
            break;
    }
}
return true;