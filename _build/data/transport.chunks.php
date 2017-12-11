<?php
/** @var modX $modx */
/** @var array $sources */

$chunks = array();

$tmp = array(
    // tcBillboardForm
    'tcBillboardFormCreateTpl' => array(
        'file' => 'tcbillboardformcreate',
        'description' => '',
    ),
    'tcBillboardFormPreviewTpl' => array(
        'file' => 'tcbillboardformpreview',
        'description' => '',
    ),
    'tcBillboardEmailNewManagerTpl' => array(
        'file' => 'tcbillboardemailnewmanager',
        'description' => '',
    ),
    'tcBillboardEmailPaidUserTpl' => array(
        'file' => 'tcbillboardemailpaiduser',
        'description' => '',
    ),
    'tcBillboardEmailPaidManagerTpl' => array(
        'file' => 'tcbillboardemailpaidmanager',
        'description' => '',
    ),
    'tcBillboardEmailCancelledUserTpl' => array(
        'file' => 'tcbillboardemailcancelleduser',
        'description' => '',
    ),
    'tcBillboardImageTpl' => array(
        'file' => 'tcbillboardimage',
        'description' => '',
    ),
    'tcBillboardImagesTpl' => array(
        'file' => 'tcbillboardimages',
        'description' => '',
    ),
    'tcBillboardScoreTpl' => array(
        'file' => 'tcbillboardscore',
        'description' => '',
    ),
    'tcBillboardEmailInvoiceTpl' => array(
        'file' => 'tcbillboardemailinvoice',
        'description' => '',
    ),
    'tcBillboardEmailInvoiceNewPdfTpl' => array(
        'file' => 'tcbillboardemailinvoicenewpdf',
        'description' => '',
    ),
    'tcBillboardWarningPdf1Tpl' => array(
        'file' => 'tcbillboardwarningpdf1',
        'description' => '',
    ),
    'tcBillboardWarningPdf2Tpl' => array(
        'file' => 'tcbillboardwarningpdf2',
        'description' => '',
    ),
    'tcBillboardSuccessBankTpl' => array(
        'file' => 'tcbillboardsuccessbank',
        'description' => '',
    ),
    'tcBillboardSuccessPayPalTpl' => array(
        'file' => 'tcbillboardsuccesspaypal',
        'description' => '',
    ),
    // tcBillboard
    'tcBillboardPreviewTpl' => array(
        'file' => 'tcbillboardpreview',
        'description' => '',
    )
);

// Save chunks for setup options
$BUILD_CHUNKS = array();

foreach ($tmp as $k => $v) {
    /** @var modChunk $chunk */
    $chunk = $modx->newObject('modChunk');
    $chunk->fromArray(array(
        'id' => 0,
        'name' => $k,
        'description' => @$v['description'],
        'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v['file'] . '.tpl'),
        'static' => BUILD_CHUNK_STATIC,
        'source' => 1,
        'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/chunks/chunk.' . $v['file'] . '.tpl',
    ), '', true, true);

    $chunks[] = $chunk;

    $BUILD_CHUNKS[$k] = file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v['file'] . '.tpl');
}
unset($tmp);

return $chunks;