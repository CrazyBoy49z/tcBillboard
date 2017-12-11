<?php

//return $_REQUEST;

if (empty($_REQUEST['action'])) {
    die('Access denied');
} else {
    $action = $_REQUEST['action'];
}

define('MODX_API_MODE', true);
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';

$modx->getService('error', 'error.modError');
$modx->getRequest();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
$modx->error->message = null;

$tcBillboard = $modx->getService('tcbillboard', 'tcBillboard', $modx->getOption('tcbillboard_core_path', null,
        $modx->getOption('core_path') . 'components/tcbillboard/') . 'model/tcbillboard/');

if ($modx->error->hasError() || !($tcBillboard instanceof tcBillboard)) {
    die('Error');
}

switch ($action) {
    case 'tcbillboard/titul/upload':
        $response = $tcBillboard->fileUpload($_POST, 'tcBillboard');
        break;

    case 'tcbillboard/titul/remove':
        $response = $tcBillboard->fileRemove($_POST, 'tcBillboard');
        break;

    case 'tcBillboard/setSession':
        $response = $tcBillboard->setSessionPayment($_POST['value']);
        break;

    case 'tcBillboard/publish':
        $response = $tcBillboard->setSessionPayment($_POST['value'], true);
        break;

    case 'tcbillboard/pubdate':
    case 'tcbillboard/unpubdate':
        $response = $tcBillboard->prepareDate($_POST['value'], $_POST['action']);
        break;

    case 'tcbillboard/startstock':
    case 'tcbillboard/endstock':
        $response = $tcBillboard->prepareDate($_POST['value'], $_POST['action']);
        break;

    case 'tcBillboard/paymentPayPal':
        $response = $tcBillboard->processPayPalPayment($_POST['value'], (int)$_POST['res']);
        break;
}
if (is_array($response)) {
    $response = json_encode($response);
}

@session_write_close();
exit($response);