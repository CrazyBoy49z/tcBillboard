<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            // Assign policy to template
            if ($policy = $modx->getObject('modAccessPolicy', array('name' => 'tcBillboardTicketUserPolicy'))) {
                if ($template = $modx->getObject('modAccessPolicyTemplate',
                    array('name' => 'tcBillboardTicketsUserPolicyTemplate'))
                ) {
                    $policy->set('template', $template->get('id'));
                    $policy->save();
                } else {
                    $modx->log(xPDO::LOG_LEVEL_ERROR,
                        '[tcBillboard] Could not find tcBillboardTicketsUserPolicyTemplate Access Policy Template!');
                }
            } else {
                $modx->log(xPDO::LOG_LEVEL_ERROR, '[tcBillboard] Could not find tcBillboardTicketUserPolicy Access Policy!');
            }

            if ($policyManager = $modx->getObject('modAccessPolicy', array('name' => 'tcBillboardManagerPolicy'))) {
                if ($templateManager = $modx->getObject('modAccessPolicyTemplate',
                    array('name' => 'tcBillboardManagerPolicyTemplate'))
                ) {
                    $policyManager->set('template', $templateManager->get('id'));
                    $policyManager->save();
                } else {
                    $modx->log(xPDO::LOG_LEVEL_ERROR,
                        '[tcBillboard] Could not find tcBillboardTicketsUserPolicyTemplate Access Policy Template!');
                }

                /** @var modUserGroup $adminGroup */
                if ($adminGroup = $modx->getObject('modUserGroup', array('name' => 'Administrator'))) {
                    $properties = array(
                        'target' => 'mgr',
                        'principal_class' => 'modUserGroup',
                        'principal' => $adminGroup->get('id'),
                        'authority' => 9999,
                        'policy' => $policyManager->get('id'),
                    );
                    if (!$modx->getObject('modAccessContext', $properties)) {
                        $access = $modx->newObject('modAccessContext');
                        $access->fromArray($properties);
                        $access->save();
                    }
                }
                break;
            } else {
                $modx->log(xPDO::LOG_LEVEL_ERROR, '[tcBillboard] Could not find tcBillboardTicketUserPolicy Access Policy!');
            }
            break;
    }
}

return true;