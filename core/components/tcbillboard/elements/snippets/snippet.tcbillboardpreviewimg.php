<?php

$output = '';

$q = $modx->newQuery('TicketFile');
$q->select('url, thumb');
$q->where(array(
    'class' => 'Ticket',
    'parent' => $id,
    'createdby' => $modx->user->id,
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
