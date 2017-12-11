<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/** @var modX $modx */
/** @var array $scriptProperties */
/** @var tcBillboard $tcBillboard */

if (!$modx->loadClass('tcBillboard', MODX_CORE_PATH . 'components/tcbillboard/model/tcbillboard/', false, true)) {
    return false;
}
$tcBillboard = new tcBillboard($modx, $scriptProperties);

$tpl = $modx->getOption('tpl', $scriptProperties, 'tcBillboardPreviewTpl', true);
$createdBy = trim($modx->getOption('createdBy', $scriptProperties, ''));
$resourceFields = $modx->getOption('resourceFields', $scriptProperties, '', true);

$output = '';
$tmp = array();

$q = $modx->newQuery('modResource');
$q->leftJoin('tcBillboardOrders', 'Orders', 'modResource.id = Orders.res_id');
if (!empty($resourceFields)) {
    $q->select($resourceFields);
}
$q->select('Orders.*');
$q->where(array(
    'class_key' => 'Ticket',
));

if (!empty($createdBy)) {
    $q->where(array(
        'createdby' => $createdBy,
    ));
}

if ($q->prepare() && $q->stmt->execute()) {
    while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
        $tmp[] = $row;
    }
}

print '<pre>';
print_r($tmp);
print '</pre>';

return $output;
