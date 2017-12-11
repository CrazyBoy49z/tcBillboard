<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var tcBillboard $tcBillboard */

if (!$modx->loadClass('tcBillboard', MODX_CORE_PATH . 'components/tcbillboard/model/tcbillboard/', false, true)) {
    return false;
}

if (!$modx->user->isAuthenticated($modx->context->key))
    return;

$tcBillboard = new tcBillboard($modx, $scriptProperties);

$allowedFields = $modx->getOption('allowedFields', $scriptProperties, 'parent,pagetitle,content,pub_date,unpub_date', true);
$requiredFields = $modx->getOption('requiredFields', $scriptProperties, 'parent,pagetitle,content,pub_date,unpub_date', true);
$tplFormCreate = $modx->getOption('tplFormCreate', $scriptProperties, 'tcBillboardFormCreateTpl', true);
$tplPreview = $modx->getOption('tplPreview', $scriptProperties, 'tcBillboardFormPreviewTpl', true);
$tplImage = $modx->getOption('tplImage', $scriptProperties, 'tcBillboardImageTpl', true);
$tplScore = $modx->getOption('tplScore', $scriptProperties, 'tcBillboardScoreTpl', true);
$tplInvoiceNew = $modx->getOption('tplInvoiceNew', $scriptProperties, 'tcBillboardEmailInvoiceTpl', true);
$tplInvoiceNewPdf = $modx->getOption('tplInvoiceNewPdf', $scriptProperties, 'tcBillboardEmailInvoiceNewPdfTpl', true);
$tplSuccessBank = $modx->getOption('tplSuccessBank' , $scriptProperties, 'tcBillboardSuccessBankTpl', true);
$tplSuccessPayPal = $modx->getOption('tplSuccessPayPal' , $scriptProperties, 'tcBillboardSuccessPayPalTpl', true);
$frontendCss = trim($modx->getOption('frontedCss', $scriptProperties, 'components/tcbillboard/css/web/tcbillboard.css', true));
$frontendJsFile = trim($modx->getOption('frontendJsFile', $scriptProperties, 'components/tcbillboard/js/web/tcbillboardfile.js', true));
$frontendJs = trim($modx->getOption('frontendJs', $scriptProperties, 'components/tcbillboard/js/web/tcbillboard.js', true));

$source = empty($scriptProperties['source'])
    ? $modx->getOption('tcbillboard_source_default')
    : $scriptProperties['source'];
$tid = !empty($_REQUEST['tid'])
    ? (int)$_REQUEST['tid']
    : 0;
$form = '';
$chunk = '';
$thumb = $tcBillboard->getMaskTitulPath();
$name = '';
$displayNone = ' tcbillboard-display-none';

$tcBillboard->loadJsCss('tplFormCreate', $scriptProperties);
$form = $tcBillboard->process('TicketForm', $scriptProperties);

if ($userProfile = $tcBillboard->getUserProfile($modx->user->id)) {
    if (!empty($userProfile->photo)) {
        $thumb = $userProfile->photo;
        $name = '';
    }
}

$q = $modx->newQuery('TicketFile');
$q->where(array(
    'class' => 'tcBillboard',
    'parent' => $tid,
    'source' => $source,
    'createdby' => $modx->user->id,
));

$collection = $modx->getIterator('TicketFile', $q);

foreach ($collection as $item) {
    if ($item->get('deleted') && !$item->get('parent')) {
        $item->remove();
    } else {
        $properties = $item->toArray();
        if (!empty($properties['thumb'])) {
            $thumb = $properties['thumb'];
            $displayNone = '';
        }
        $name = $properties['name'];
    }
}

$modx->toPlaceholders(array(
    'thumb' => $thumb,
    'name' => $name,
    'display' => $displayNone,
));

return $form;