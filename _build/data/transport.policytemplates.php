<?php
$templates = array();
$tmp = array(
    'tcBillboardTicketsUserPolicyTemplate' => array(
        'description' => 'A policy for users to create Tickets, tcBillboard and comments.',
        'template_group' => 1,
        'permissions' => array(
            'ticket_delete' => array(),
            'ticket_publish' => array(),
            'ticket_save' => array(),
            'ticket_view_private' => array(),
            'ticket_vote' => array(),
            'ticket_star' => array(),
            'comment_save' => array(),
            'comment_delete' => array(),
            'comment_remove' => array(),
            'comment_publish' => array(),
            'comment_vote' => array(),
            'comment_star' => array(),
            'ticket_file_upload' => array(),
            'ticket_file_delete' => array(),
            'thread_close' => array(),
            'thread_delete' => array(),
            'thread_remove' => array(),
            'publish_document' => array(),
            'view_unpublished' => array(),
        ),
    ),
    'tcBillboardManagerPolicyTemplate' => array(
        'description' => 'A policy for tcBillboard managers.',
        'template_group' => 1,
        'permissions' => array(
            'tborder_import' => array(),
            'tborder_invoice_list' => array(),
            'tborder_view' => array(),
            'tborder_list' => array(),
            'tborder_remove' => array(),
            'tborder_save' => array(),
            'tborder_warning_list' => array(),
            'tbsetting_view' => array(),
            'tbsetting_list' => array(),
            'tbsetting_remove' => array(),
            'tbsetting_save' => array(),
        ),
    ),
);
/** @var modx $modx */
foreach ($tmp as $k => $v) {
    $permissions = array();
    if (isset($v['permissions']) && is_array($v['permissions'])) {
        foreach ($v['permissions'] as $k2 => $v2) {
            /** @var modAccessPermission $event */
            $permission = $modx->newObject('modAccessPermission');
            $permission->fromArray(array_merge(array(
                    'name' => $k2,
                    'description' => $k2,
                    'value' => true,
                ), $v2)
                , '', true, true);
            $permissions[] = $permission;
        }
    }
    /** @var $template modAccessPolicyTemplate */
    $template = $modx->newObject('modAccessPolicyTemplate');
    $template->fromArray(array_merge(array(
            'name' => $k,
            'lexicon' => PKG_NAME_LOWER . ':permissions',
        ), $v)
        , '', true, true);
    if (!empty($permissions)) {
        $template->addMany($permissions);
    }
    $templates[] = $template;
}
return $templates;