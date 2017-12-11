<?php
if (!$modx->loadClass('tcBillboard', MODX_CORE_PATH
    . 'components/tcbillboard/model/tcbillboard/', false, true)) {
    return;
}
$tcBillboard = new tcBillboard($modx, $scriptProperties);

/** @var modX $modx */
switch ($modx->event->name) {
    case 'OnManagerPageBeforeRender':
        $logout = $modx->getOption('tcbillboard_admin_logout_time');
        if ($logout == 0) { return; }

        $script = "<script>\n\t";
        $script .= "function setLogoutTimer(){if (logoutTimer) clearTimeout(logoutTimer); 
            return setTimeout(function(){location.href='?a=security/logout';}, "
            . $logout . "*60000);};" . "\n\t";
        $script .= "var logoutTimer = setLogoutTimer();\n\t";
        $script .= 'document.addEventListener("click" , function() { logoutTimer = setLogoutTimer(); }, true);' . "\n\t";
        $script .= 'document.addEventListener("mousemove" , function() { logoutTimer = setLogoutTimer(); }, true);' . "\n\t";
        $script .= 'document.addEventListener("contextmenu" , function() { logoutTimer = setLogoutTimer(); }, true);' . "\n\t";
        $script .= 'document.addEventListener("wheel" , function() { logoutTimer = setLogoutTimer(); }, true);' . "\n\t";
        $script .= 'document.addEventListener("keydown" , function() { logoutTimer = setLogoutTimer(); }, true);' . "\n";
        $script .= "</script>";
        $modx->controller->addHtml($script);
        break;

    case 'OnDocFormSave':
        if (!$resource instanceof Ticket) { return; }

        if ($mode == 'new') {
            $user = $modx->user->id;
            // Изменить путь до файла после публикации
            if ($file = $modx->getObject('TicketFile', array(
                'parent' => 0,
                'createdby' => $user,
                'deleted' => 0,
            ))) {
                $path['url'] = $file->get('url');
                $path['thumb'] = $file->get('thumb');
                $path['thumbs'] = $file->get('thumbs');

                foreach ($path as $k => $v) {
                    if ($k == 'thumbs') {
                        foreach ($v as $key => $val) {
                            $file->set($k, array($key => str_replace('/0/', '/' . $id . '/', $val)));
                        }
                    } else {
                        $file->set($k, str_replace('/0/', '/' . $id . '/', $v));
                    }
                }
                $file->set('parent', $id);
                $file->save();
            }
            // Записываем даты и правильную длину introtext
            if ($ticket = $modx->getObject('modResource', array(
                'id' => $id,
                'class_key' => 'Ticket',
            ))) {
                $date = time();
                $pubDate = strtotime($ticket->get('pub_date'));
                $limitIntrotext = $modx->getOption('tcbillboard_limit_introtext', null, 200);
                $introtext = $ticket->get('introtext');

                if (mb_strlen($introtext) > $limitIntrotext) {
                    $tmp = mb_substr($introtext, 0, $limitIntrotext);
                    $tmp = mb_substr($tmp, 0, mb_strripos($tmp, ' ', 0));
                    $ticket->set('introtext', $tmp);
                }

                if ($pubDate > $date) {
                    $ticket->set('publishedon', 0);
                    $ticket->set('published', 0);
                } else {
                    $ticket->set('pub_date', 0);
                }
                $ticket->save();
            }
            // Сохранить ордер
            if (!$status = $tcBillboard->orderSave($resource, $id)) {
                $modx->log(1, $modx->event->name . ' '
                    . $this->modx->lexicon('tcbillboard_err_order_save'));
            }
            // Подготовить и отправить инвойс
            $order = $resource->getOne('Orders')
                ->toArray();
            $dataRes = $resource->toArray();
            $dataRes['paymentName'] = $tcBillboard->getPaymentName($order['payment']);
            unset($dataRes['id']);
            $data = array_merge($order, $dataRes);
            $tcBillboard->prepareInvoice($data);
        }
        break;

    case 'OnLoadWebDocument':
        // Подмена файла default.js на customdefault.js, в Tickets
        if ($modx->resource->id == (int)$modx->getOption('tcbillboard_resource_form')) {
            $modx->setOption('tickets.frontend_js', '[[+jsUrl]]web/customdefault.js');
        }
        // Подменяет контент на текст с благодарностью или оплату PayPal
        if ($_GET['tcbillboard'] == 'payment') {
            if (!$modx->user->isAuthenticated($modx->context->key)
                || !$tcBillboard->getTotalCostOrder($modx->resource->id)) {

                $modx->sendRedirect($modx->makeUrl($modx->resource->id, '', '', 'full'));
            }
            $modx->resource->set('cacheable', 0);
            if ($_SESSION['tcBillboard']['payment'] == 1) {
                $modx->resource->setProperties(array(
                    'disable_jevix' => 1,
                    'process_tags' => 1,
                ), 'tickets');
                $modx->resource->set('content', $tcBillboard->chunkGratitude($modx->resource->id));
            } elseif ($_SESSION['tcBillboard']['payment'] == 2) {
                $modx->resource->setProperties(array(
                    'disable_jevix' => 1,
                    'process_tags' => 1,
                ), 'tickets');
                $modx->resource->set('content', $tcBillboard->chunkGratitude($modx->resource->id));
            }
            unset($_SESSION['tcBillboard']['order']);
            unset($_SESSION['tcBillboard']['startstock']);
            unset($_SESSION['tcBillboard']['endstock']);
            unset($_SESSION['tcBillboard']['pubdate']);
            unset($_SESSION['tcBillboard']['unpubdate']);
        }
        // Отмечает чекбокс "Удалён" у ресурса
        if ($deleteDay = $modx->getOption('tcbillboard_delete_day')) {
            $time = time() - $deleteDay * 24 * 60 * 60;
            $tcBillboard->deleteResource($time, 'delete');
        }
//        if ($firstWarning = $modx->getOption('tcbillboard_first_warning')) {
//            $time = time() - $firstWarning * 24 * 60 * 60;
//            $test = $tcBillboard->parseOption($time, 'first_warning');
//        }

        if (!$tcBillboard->prepareRequestPenalty()) {
            $modx->log(1, $modx->event->name . ' '
                . $this->modx->lexicon('tcbillboard_err_request_penalty'));
        }

        // Процессор очистки корзины
        //$response = $modx->runProcessor('resource/emptyrecyclebin');
        //if ($response->isError()) $response->getMessage();

        //$modx->log(1, $modx->event->name . ' ' . print_r($test, 1));

        //$tcBillboard->test(); 1504874436

        //$modx->sendRedirect($modx->makeUrl(1,'','','full'));

        //$modx->log(1, $modx->event->name . ' ' . print_r($modx->resource->id, 1));

        //$modx->resource->setContent($test);
        break;

    case 'OnManagerAuthentication':
        // Отправляет на проверку просрочки оплаты
        if (!$tcBillboard->prepareRequestPenalty()) {
            $modx->log(1, $modx->event->name . ' '
                . $this->modx->lexicon('tcbillboard_err_request_penalty'));
        }
        break;

    case 'tcBillboardAfterCancelOrder':
        // Срабатывает после изменения статуса ордера
        // $mode - new | upd | incasso
        // $order - Массив с данными ордера
        /** @var tcBillboardOrders $order */
        switch ($mode) {
            case 'new':
            case 'incasso':
                    $tcBillboard->changeStatusEmail($order);
                break;
        }
        break;

    case 'OnEmptyTrash':
        if ($ids) {
            foreach ($ids as $id) {
                $pathTickets = MODX_ASSETS_PATH . 'images/tickets/' . $id . '/';
                $pathTcBillboard = MODX_ASSETS_PATH . 'images/tcbillboard/' . $id . '/';
                if (file_exists($pathTickets)) {
                    $tcBillboard->removeDir($pathTickets);
                }
                if (file_exists($pathTcBillboard)) {
                    $tcBillboard->removeDir($pathTcBillboard);
                }
            }
            //$tcBillboard->removeCollectionFile('TicketFile');
        }
        break;
}
