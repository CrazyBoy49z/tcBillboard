<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var tcBillboard $tcBillboard */

if (!$modx->user->isAuthenticated($modx->context->key)) {
    $modx->sendRedirect($modx->makeUrl($modx->getOption('site_start'),'','','full'));
}

if (!$modx->loadClass('tcBillboard', MODX_CORE_PATH . 'components/tcbillboard/model/tcbillboard/', false, true)) {
    return false;
}
$tcBillboard = new tcBillboard($modx, $scriptProperties);

$tpl = $modx->getOption('tpl', $scriptProperties, 'tcBillboardMyOrdersTpl', true);
$tplWrapper = $modx->getOption('tplWrapper', $scriptProperties, 'tcbillboardMyOrdersWrapperTpl', true);
$user = $modx->getOption('user', $scriptProperties, $modx->user->id, true);
$sortby = $modx->getOption('sortby', $scriptProperties, 'DESC');
$fields = $modx->getOption('fields', $scriptProperties, '', true);
$pagination = $modx->getOption('pagination', $scriptProperties, true);

$dateFormat = $tcBillboard->config['dateFormat'];
$fields = array_map('trim', explode(',', $fields));

$output = '';
$items = $pagination == true ? array() : '';
$tmp = array();

$q = $modx->newQuery('tcBillboardOrders', array('user_id' => (int)$user));
$q->select($modx->getSelectColumns('tcBillboardOrders', 'tcBillboardOrders', '', $fields));
$q->sortby('id', $sortby);
//$q->limit(5);

if ($q->prepare() && $q->stmt->execute()) {
    while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
        $tmp[] = $row;

        if ($row['pubdatedon']) {
            $row['pubdatedon'] = date($dateFormat, strtotime($row['pubdatedon']));
        }
        if ($row['unpubdatedon']) {
            $row['unpubdatedon'] = date($dateFormat, strtotime($row['unpubdatedon']));
        }
        if ($row['start_stock']) {
            $row['start_stock'] = date($dateFormat, strtotime($row['start_stock']));
        }
        if ($row['end_stock']) {
            $row['end_stock'] = date($dateFormat, strtotime($row['end_stock']));
        }

        if ($pagination) {
            $items[] = $tcBillboard->getChunk($tpl, $row);
        } else {
            $items .= $tcBillboard->getChunk($tpl, $row);
        }
    }
}

// Пагинация pdoPage
if ($pagination) {
    $modx->setPlaceholder($totalVar, count($items));
    $items = array_slice($items, $offset, $limit, true);

    foreach ($items as $item) {
        $t .= $item;
    }
}

$output = $tcBillboard->getChunk($tplWrapper, array(
    'output' => $pagination == true ? $t : $items,
));

if (empty($tpl)) {
    print '<pre>';
    print_r($tmp);
    print '</pre>';
} else {
    return $output;
}
