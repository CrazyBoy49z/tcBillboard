<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var tcBillboard $tcBillboard */

$createdBy = $modx->getOption('createdBy', $scriptProperties, $modx->user->id, true);

$output = '';

$q = $modx->newQuery('TicketFile');
$q->select('url, thumb');
$q->where(array(
    'class' => 'Ticket',
    'parent' => $id,
    'createdby' => $createdBy,
    'deleted' => 0,
));

if ($q->prepare() && $q->stmt->execute()) {
    while($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
        $files[] = $row;
        if ($pdoTools = $modx->getService('pdoTools')) {
            $output .= $pdoTools->getChunk($tpl, $row);
        } else {
            $output .= $modx->getChunk($tpl, $row);
        }
    }
}

return $output;
