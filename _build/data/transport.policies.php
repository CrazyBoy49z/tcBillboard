<?php
$policies = array();
$tmp = array(
    'tcBillboardTicketUserPolicy' => array(
        'description' => 'A policy for create, publish and update Tickets.',
        'data' => array(
            'ticket_delete' => true,
            'ticket_publish' => true,
            'ticket_save' => true,
            'ticket_vote' => true,
            'ticket_star' => true,
            'comment_save' => true,
            'comment_delete' => true,
            'comment_remove' => true,
            'comment_publish' => true,
            'comment_vote' => true,
            'comment_star' => true,
            'ticket_file_upload' => true,
            'ticket_file_delete' => true,
            'thread_close' => true,
            'thread_delete' => true,
            'thread_remove' => true,
            'publish_document' => true,
            'view_unpublished' => true,
        ),
    ),
    'tcBillboardManagerPolicy' => array(
        'description' => 'Order editing policy tcBillboard',
        'data' => array(
            'tborder_import' => false,
            'tborder_invoice_list' => true,
            'tborder_view' => true,
            'tborder_list' => true,
            'tborder_remove' => true,
            'tborder_save' => true,
            'tborder_warning_list' => true,
            'tbsetting_view' => true,
            'tbsetting_list' => true,
            'tbsetting_remove' => true,
            'tbsetting_save' => true,
        ),
    ),
);
/** @var modx $modx */
foreach ($tmp as $k => $v) {
    if (isset($v['data'])) {
        $v['data'] = json_encode($v['data']);
    }
    /** @var $policy modAccessPolicy */
    $policy = $modx->newObject('modAccessPolicy');
    $policy->fromArray(array_merge(array(
            'name' => $k,
            'lexicon' => PKG_NAME_LOWER . ':permissions',
        ), $v)
        , '', true, true);
    $policies[] = $policy;
}
return $policies;