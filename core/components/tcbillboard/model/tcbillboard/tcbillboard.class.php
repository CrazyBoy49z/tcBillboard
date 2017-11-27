<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class tcBillboard
{
    /** @var modX $modx */
    public $modx;
    /** @var pdoTools $pdoTools */
    public $pdoTools;
    /** @var MpdfTc $MpdfTc */
    public $MpdfTc;
    /** @var bool */
    public $authenticated = false;
    /** @var array $order */
    public $order = array();
    /** @var $user */
    public $user;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('tcbillboard_core_path', $config,
            $this->modx->getOption('core_path') . 'components/tcbillboard/'
        );
        $assetsUrl = $this->modx->getOption('tcbillboard_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/tcbillboard/'
        );
        $dateFormat = trim($this->modx->getOption('tcbillboard_date_formate'));
        $connectorUrl = $assetsUrl . 'connector.php';
        $actionUrl = $assetsUrl . 'action.php';
        //$ticketsActionUrl = $assetsUrl . 'ticketsaction.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'imagesUrl' => $assetsUrl . 'images/',

            'dateFormat' => $dateFormat,
            'tmpPath' => MODX_CORE_PATH . 'components/tcbillboard/tmp/',
            'source' => $this->modx->getOption('tcbillboard_source_default'),

            'connectorUrl' => $connectorUrl,
            'actionUrl' => $actionUrl,
            'ticketsActionUrl' => MODX_ASSETS_URL . 'components/tickets/ticketsaction.php',

            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'templatesPath' => $corePath . 'elements/templates/',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'processorsPath' => $corePath . 'processors/',
        ), $config);

        $this->modx->addPackage('tcbillboard', $this->config['modelPath']);
        $this->modx->lexicon->load('tcbillboard:default');

        $this->authenticated = $this->modx->user->isAuthenticated($this->modx->context->get('key'));
        if ($user = $this->modx->getObject('modUser',$this->modx->user->id)) {
            $this->user = $user->getOne('Profile');
        }
    }


    public function loadJsCss($object, $scriptProperties = array())
    {
        $this->modx->regClientCSS($this->config['cssUrl'] . 'web/lib/bootstrap-datetimepicker.min.css');
        $this->modx->regClientCSS($this->config['cssUrl'] . 'web/lib/jquery.fancybox.min.css');
        if (!empty($scriptProperties['frontedCss'])) {
            $this->modx->regClientCSS(MODX_ASSETS_URL . $scriptProperties['frontedCss']);
        }
        $this->modx->regClientScript($this->config['jsUrl'] . 'web/lib/moment-with-locales.min.js');
        $this->modx->regClientScript($this->config['jsUrl'] . 'web/lib/bootstrap-datetimepicker.min.js');
        $this->modx->regClientScript($this->config['jsUrl'] . 'web/lib/jquery.fancybox.min.js');
        //$this->modx->regClientScript($this->config['jsUrl'] . 'web/tcbillboard.js');
        if (!empty($scriptProperties['frontendJsFile'])) {
            $this->modx->regClientScript(MODX_ASSETS_URL . $scriptProperties['frontendJsFile']);
        }
        if (!empty($scriptProperties['frontendJs'])) {
            $this->modx->regClientScript(MODX_ASSETS_URL . $scriptProperties['frontendJs']);
        }

        $this->modx->regClientScript('<script type="text/javascript">
            tcBillboardTicketsConfig={"ticketsActionUrl":"' . $this->config['ticketsActionUrl'] . '"};</script>', true);

        $this->modx->regClientHTMLBlock('<script>tcBillboard.initialize({ 
            "actionUrl":"' . $this->config['actionUrl'] . '",
            "selectorForm":"tcbillboard-form"});
        </script>');

        return true;
    }


    /**
     * Обработка подключаемого сниппета
     * @param $name
     * @param array $scriptProperties
     * @return bool
     */
    public function process($name, array $scriptProperties = array())
    {
        if ($snippet = $this->modx->getObject('modSnippet', array('name' => $name))) {
            $properties = $snippet->getProperties();
            $cod = $snippet->get('snippet');

            $snippet->set('snippet', str_replace('web/files.js', 'web/customfiles.js', $cod));
            //$snippet->set('snippet', str_replace('web/default.js', 'web/customdefault.js', $cod));
            $scriptProperties = array_merge($properties, $scriptProperties);

            $snippet->_cacheable = false;
            $snippet->_processed = false;

            $response = $snippet->process($scriptProperties);
            return $response;
        } else {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                $this->modx->lexicon('tcbillboard_err_empty_snippet') . $name);
        }
        return false;
    }


    /**
     * Подготавливает запрос неустойки
     * @return bool
     */
    public function prepareRequestPenalty()
    {
        $reply = false;
        // Получить список штрафов
        $penalty = $this->getPenalty();
        if ($penalty) {
            $i = 0;
            foreach ($penalty as $item) {
                $maxDate = time() - (int)$item['days'] * 24 * 60 * 60;
                // Получить ордера с просроченной оплатой
                $orders = $this->getOrdersPenalty($maxDate, $notice = $i == 0 ? null : $i);
                    if ($orders) {
                        // Обновить ордер
                        $this->updateOrdersPenalty($item, $orders, $i + 1);
                    }
                    unset($item);
                $i++;
            }
            $reply = true;
        }
        return $reply;
    }


    /**
     * Записывает неустойку (штраф) в ордер
     * $penaltyItem - данные одного пункта неустойки
     * $orders - массив с просроченными (не оплаченными) ордерами
     * $notice - номер уведомления
     * @param array $penaltyItem
     * @param array $orders
     * @param $notice
     */
    public function updateOrdersPenalty(array $penaltyItem, array $orders, $notice)
    {
        foreach ($orders as $order) {
            $penalty = null;
            $formula = $penaltyItem['formula'];

            if ($formula != 'incasso') {
                $str = $order['sum'] . $formula;
                eval('$s = ' . $str . ';');
                $penalty = (float)round($s, 2);
            }
            if ($obj = $this->modx->getObject('tcBillboardOrders', (int)$order['id'])) {
                $obj->set('notice', $notice);
                $obj->set('date_notice', date($this->config['dateFormat']));
                if ($formula == 'incasso') {
                    $obj->set('penalty', 'incasso');
                    $this->runProcessor('resource/delete', array('id' => $order['res_id']));
                } else {
                    $obj->set('penalty', $penalty);
                }
                $obj->save();

                // Отправляем на подготовку PDF-файла
                $data = array_merge($penaltyItem, $order);
                $data['penalty'] = $penalty;
                $data['notice'] = $notice;
                // Итого вместе со штрафом
                $data['cost'] = $data['sum'] + $data['penalty'];

                //return $data;
                $this->prepareInvoice($data, 'warning_' . $notice);
            }
            unset($order);
        }
        return;
    }



    /**
     * Получает ордера с просроченной оплатой
     * $maxDate - последний день оплаты
     * $notice - количество предупреждений
     * @param $maxDate
     * @param $notice
     * @return array
     */
    public function getOrdersPenalty($maxDate, $notice)
    {
        $orders = array();

        $q = $this->modx->newQuery('tcBillboardOrders');
        $q-> select('id, pubdatedon, paymentdate, sum, notice, penalty, num,
            createdon, user_id');
        $q->where(array(
            'paymentdate:IS' => null,
            'sum:>' => 0,
            'notice' => $notice,
        ));
        $q->andCondition(array(
            'createdon:<' => date('Y-m-d 00:00:00', $maxDate),
        ));
        //$q->limit(1);
        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders[] = $row;
            }
        }
        return $orders;
    }


    /**
     * Получает список неустоек (штрафов)
     * @param bool $active
     * @return array|bool
     */
    public function getPenalty($active = true)
    {
        $penalty = array();

        if (!$q = $this->modx->newQuery('tcBillboardPenalty')) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                $this->modx->lexicon('tcbillboard_err_penalty_table'));
            return false;
        }
        $q->select('id, days, formula, percent, fine, chunk, active');
        $q->where(array(
            'active' => $active,
        ));
        $q->sortby('days');
        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $penalty[] = $row;
            }
        }
        return $penalty;
    }


    /**
     * Удаляет ресурс через указанное время $time
     * @param $time
     * @param string $mode
     */
    public function deleteResource($time, $mode = '')
    {
        //$tmp = array();

        $q = $this->modx->newQuery('tcBillboardOrders');
        $q->select('res_id, unpubdatedon, pubdatedon, paymentdate, notice');

        if ($mode == 'delete') {
            $q->andCondition(array(
                'unpubdatedon:<' => date('Y-m-d 00:00:00', $time),
            ), null, 1);
        }
//        if ($mode == 'first_warning') {
//            $q->andCondition(array(
//                //'pubdatedon:<' => date('Y-m-d 00:00:00', $time),
//                'paymentdate:IS' => null,
//                'notice:=' => 0
//            ), null, 1);
//        }

        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['res_id'] && $mode == 'delete') {
                    $response = $this->runProcessor('resource/delete', array('id' => $row['res_id']));
                    if ($response->isError()) {
                        $this->modx->log(modX::LOG_LEVEL_ERROR,
                            $this->modx->lexicon('tcbillboard_err_delete_resource') . ': ' . $row['res_id']);
                    }
                }
            }
        }
        return;
    }


    /**
     * Подключить класс MpdfTc
     *
     * @return bool|MpdfTc
     */
    public function getMpdfTc()
    {
        if (!$this->MpdfTc) {
            try {
                if (!class_exists('MpdfTc')) {
                    require 'MpdfTc.php';
                }
                $this->MpdfTc = new MpdfTc($this);
            } catch (Exception $err) {
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, $err->getMessage());
                return false;
            }
        }
        return $this->MpdfTc;
    }


    /**
     * @param $num
     * @param $pdf
     * @param $userId
     * @param string $mode
     * @param string $chunk
     * @param bool $sendEmail
     * @return string
     */
    public function Mpdf($num, $pdf, $userId, $mode = 'invoice', $chunk = '', $sendEmail = true)
    {
        if (!$mpdf = $this->getMpdfTc()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                $this->modx->lexicon('tcbillboard_err_service') . ': getMpdfTc');
        }

        $exportPath = $this->exportPath();
        $path = $exportPath . date('Y') . '/' . date('m') . '/' . date('d') . '/'
            . $userId . '/' . $mode . '/';

        if (!is_dir($path)) {
            $this->mkdir($path, 0755, true);
        }

        $pathPdf = $mpdf->createPdfFile($path, $num, $pdf);
        if ($sendEmail) {
            $this->sendEmail($chunk, $pathPdf);
        }
        unset($mpdf);
        return $pathPdf;
    }


    /**
     * Папка с файлами экспорта, по умолчанию
     *
     * @return string
     */
    public function exportPath()
    {
        return $this->modx->getOption('core_path', null, MODX_CORE_PATH).'export/tcBillboard/';
    }


    /**
     * создаёт архив
     * $mode - статус создаваемого архива (invoice, warning1, warning2)
     * @param $mode
     * @return bool|string
     */
    public function packZip($mode)
    {
        $result = false;

        if($this->modx->loadClass('compression.xPDOZip', XPDO_CORE_PATH, true, true)){
            $name = $mode . '_' . date('d') . '_' . date('m') . '_' . date('Y') . '.zip';
            $tmpPath = $this->config['tmpPath'];
            $zipPath = $tmpPath . $name;
            $dirPath = $tmpPath;

            $archive = new xPDOZip($this->modx, $zipPath, array('create' => true, 'overwrite' => true));
            if ($archive->pack($dirPath)) {
                $archive->close();
                $result = $zipPath;
                //@unlink($zipPath);
            }
        }
        return $result;
    }


    /*
     * Подготавливает чанк для создания pdf-файла
     */
    public function prepareInvoice(array $data, $mode = 'invoice')
    {
        $createdon= strtotime($data['createdon']);
        $data['createdon'] = date($this->config['dateFormat'], $createdon);
        $data['date'] = date($this->config['dateFormat']);
        if ($data['percent']) {
            $data['percentPrice'] = round($data['percent'] / 100 * $data['sum'], 2);
            $data['nextWarning'] = date($this->config['dateFormat'],
                time() + 10 * 24 * 60 * 60);
            $prevWarning = strtotime($data['date_notice']);
            $data['prevWarning'] = date($this->config['dateFormat'], $prevWarning);
        }
        $t = $this->user->toArray();
        $data = array_merge($t, $t['extended'], $data);

        $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($t, 1));

        switch ($mode) {
            case 'invoice':
                $pubDate = strtotime($data['pub_date']);
                $unpubDate = strtotime($data['unpub_date']);
                $data['pub_date'] = date($this->config['dateFormat'], $pubDate);
                $data['unpub_date'] = date($this->config['dateFormat'], $unpubDate);
                $properties = $this->getSnippetProperties('tcBillboardForm');

                $pdf = $this->getChunk($properties['tplInvoiceNewPdf'], $data); // PDF в прикреплении
                $emailChunk = $this->getChunk($properties['tplInvoiceNew']); // Письмо о создании акции

                $pathPdf = $this->Mpdf($data['num'],$pdf, $this->modx->user->id, $mode, $emailChunk, true);
                $this->setPathPdf($data['id'], $pathPdf, $mode);
                break;

            case 'warning_1':
            case 'warning_2':
                $chunkName = $this->getChunkName($data['chunk']);
                $pdf = $this->getChunk($chunkName, $data);

                $pathPdf = $this->Mpdf($data['num'],$pdf, $data['user_id'], $mode, '', false);
                $this->setPathPdfWarning($data, $pathPdf);
                unset($pathPdf);
                break;
        }
    }


    /**
     * Получает название чанка по id
     * $id - ID чанка
     * @param $id
     * @return null
     */
    public function getChunkName($id)
    {
        $chunkName = null;
        if ($chunk = $this->modx->getObject('modChunk', array('id' => $id))) {
            $chunkName = $chunk->get('name');
        }
        return $chunkName;
    }


    /**
     * Получает параметры сниппета
     * @param $name
     * @return string
     */
    public function getSnippetProperties($name)
    {
        $properties = '';
        if ($snippet = $this->modx->getObject('modSnippet', array('name' => $name))) {
            $properties = $snippet->getProperties();
        }
        return $properties;
    }


    /**
     * Записывает в БД путь до файла PDF с предупреждениями
     * @param $data
     * @param $pathPdf
     */
    public function setPathPdfWarning($data, $pathPdf)
    {
        if ($file = $this->modx->newObject('tcBillboardWarnFiles')) {
            $file->set('order', $data['id']);
            $file->set('order_num', $data['num']);
            $file->set('formed_date', time());
            $file->set('file', str_replace(MODX_CORE_PATH, '', $pathPdf));
            $file->set('rank', $data['notice']);
            $file->save();
        }
        return;
    }


    /**
     * Записывает в БД путь до файла PDF
     * @param $id
     * @param $pathPdf
     * @param $mode
     * @param string $class
     */
    public function setPathPdf($id, $pathPdf, $mode, $class = 'tcBillboardOrders')
    {
        if ($order = $this->modx->getObject($class, (int)$id)) {
            $order->set($mode, str_replace(MODX_CORE_PATH, '', $pathPdf));
            $order->save();
        }
        return;
    }


    /**
     * @param $pathname
     * @param int $mode
     * @param bool $recursive
     * @return bool
     */
    public function mkdir($pathname, $mode = 0777, $recursive = false)
    {
        $response = true;
        if (!is_dir($pathname)) {
            if (!mkdir($pathname, $mode, $recursive)) {
                $response = false;
            }
        }
        return $response;
    }


    /**
     * @param $body
     * @param string $attachment
     */
    public function sendEmail($body, $attachment = '')
    {
        if (!$this->modx->getService('mail', 'mail.modPHPMailer')) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                $this->modx->lexicon('tcbillboard_err_service') . ': modPHPMailer');
        }
        $subject = $this->modx->getOption('tcbillboard_email_subject');
        $emailSender = $this->modx->getOption('tcbillboard_email_sender');
        $siteName = $this->modx->getOption('site_name');

        $this->modx->mail->setHTML(true);
        $this->modx->mail->address('to', $this->user->email);
        $this->modx->mail->set(modMail::MAIL_SUBJECT, $subject);
        $this->modx->mail->set(modMail::MAIL_BODY, $body);
        $this->modx->mail->set(modMail::MAIL_FROM, $emailSender);
        $this->modx->mail->set(modMail::MAIL_FROM_NAME, $siteName);
        if (!empty($attachment)) {
            $this->modx->mail->attach($attachment);
        }
        if (!$this->modx->mail->send()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                $this->modx->lexicon('tcbillboard_err_email_send') . ' ' . $this->modx->mail->mailer->ErrorInfo);
        }
        $this->modx->mail->reset();
    }


    /**
     * Сохранить ордер
     * @param $resource
     * @param $id
     * @return bool
     */
    public function orderSave($resource, $id)
    {
        $number = '';
        $newYear = false;
        $templateNum = $this->modx->getOption('tcbillboard_number_template', null, 'RE-{Y-m}');
        $toZero = $this->modx->getOption('tcbillboard_to_zero', null, true);

        if ($settingsYear = $this->modx->getObject('tcBillboardOption', array(
            'key' => 'tcbillboard_current_year',
        ))) {
            $currentYear = $settingsYear->get('value');
            $year = date('Y');
            if ($currentYear != $year) {
                $settingsYear->set('value', $year);
                $settingsYear->save();

                $newYear = true;
            }
        }
        if ($settingsNumber = $this->modx->getObject('tcBillboardOption', array(
            'key' => 'tcbillboard_order_number',))) {
            if ($newYear && $toZero) {
                $settingsNumber->set('value', 0);
                $settingsNumber->save();
            }
            $number = $settingsNumber->get('value');

            $settingsNumber->set('value', $number + 1);
            $settingsNumber->save();
        }
        $newNumber = $number + 1;

        $order = $this->getSession();
        $prefix = preg_replace('\'{.*?}\'si', '', $templateNum);
        preg_match('|.*\{ (.*?) \} |xs', $templateNum, $d);
        $date = date($d[1]);
        $orderId = $prefix . $date . '-' . $newNumber;

        $_SESSION['tcBillboard']['test'] = $id;

        if ($setOrder = $this->modx->newObject('tcBillboardOrders')) {
            $setOrder->fromArray(array(
                'num' => $orderId,
                'res_id' => $id,
                'stock_name' => $resource->pagetitle,
                'createdon' => $resource->createdon,
                'user_id' => $resource->createdby,
                'pubdatedon' => $resource->pub_date,
                'unpubdatedon' => $resource->unpub_date,
                'start_stock' => $order['startstock'],
                'end_stock' => $order['endstock'],
                'payment' => $order['payment'],
                'days' => $order['order']['totalDays'],
                'price' => $order['order']['price'],
                'sum' => $order['order']['cost'],
                'status' => 1,
            ));
            $setOrder->save();

            unset($_SESSION['tcBillboard']);
            return true;
        }
        return false;
    }


    /**
     * Получить название способа оплаты
     * @param $id
     * @return string
     */
    public function getPaymentName($id)
    {
        $response = '';
        if ($payment = $this->modx->getObject('tcBillboardPayment', $id)) {
            $response = $payment->get('name');
        }
        return $response;
    }


    /**
     * Разбор полученного $action ajax
     * @param $date
     * @param string $action
     * @return array|bool|string
     */
    public function prepareDate($date, $action = '')
    {
        $response = '';

        if ($action) {
            $action = str_replace('tcbillboard/', '', $action);
        } else {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                $this->modx->lexicon('tcbillboard_err_empty_action'));
        }
        $this->order = $this->setSessionDate($date, $action);

        switch ($action) {
            case 'startstock':
            case 'endstock':
                $response = $this->validateDate('startstock', 'endstock');
                break;

            case 'pubdate':
            case 'unpubdate':
                $response = $this->validateDate('pubdate', 'unpubdate', true);
                break;
        }
        return $response;
    }


    /**
     * Валидация дат календаря
     * Максимальная дата не может быть меньше или равной минимальной дате
     * @param $minDate
     * @param $maxDate
     * @param bool $count
     * @return array|bool|string
     */
    public function validateDate($minDate, $maxDate, $count = false)
    {
        if (!$this->order[$minDate] && !$this->order[$maxDate]) {
            return false;
        } else if($this->getDifference($this->order[$maxDate], $this->order[$minDate])
            || $this->order[$maxDate] == $this->order[$minDate]
        ) {
            return $count
                ? $this->error('tcbillboard_err_unpub_pub', array('unpub_pub' => 1))
                : $this->error('tcbillboard_err_endstock_end', array('end_stock' => 1));
        } else {
            $response = $count
                ? $this->processPrice($this->countDate($this->order[$minDate],
                    $this->order[$maxDate]))
                : '';
        }
        return $response;
    }


    /**
     * Обработка цен, количество заказанных дней.
     * Возвращает прайс
     * @param $days
     * @return array|string
     */
    public function processPrice($days)
    {
        $response = '';
        // Получить прайс
        if (!$days) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                $this->modx->lexicon('tcbillboard_err_get_price'));
        }
        $price = $this->exposePrice($days);

        // Если есть льготный период
        if (!empty($price['graceperiod'])) {
            $endPeriod = $this->dateFormat($price['graceperiod'], $this->config['dateFormat']);
            if ($difference = $this->getDifference($endPeriod, $this->order['unpubdate'])) {
                $priceDays = $this->countDate($endPeriod, $this->order['unpubdate']);

                $costGrace = ($days - $priceDays) * $price['graceperiodprice'];
                $price['graceDays'] = $days - $priceDays;
                $price['totalDays'] = $days;
                $price['costGrace'] = $costGrace;
                $price['cost'] = $priceDays * $price['price'] + $costGrace;
            } else {
                $cost = $days * $price['graceperiodprice'];
                $price['graceDays'] = $days;
                $price['totalDays'] = $days;
                $price['costGrace'] = $cost;
                $price['cost'] = $cost;
            }
        } else {
            $cost = $days * $price['price'];
            $price['graceDays'] = 0;
            $price['totalDays'] = $days;
            $price['costGrace'] = 0;
            $price['cost'] = $cost;
        }
        $_SESSION['tcBillboard']['order'] = $price;

        if ($snippet = $this->modx->getObject('modSnippet', array('name' => 'tcBillboardForm'))) {
            $properties = $snippet->getProperties();

            $tpl = $this->getChunk($properties['tplScore'], $price);
            $response = $this->success('tplScore', $tpl);
        }
        return $response;
    }


    /**
     * Выставить прайс
     * @param $days
     * @return mixed|null
     */
    public function exposePrice($days)
    {
        $price = null;
        if ($tcBillboardPrice = $this->getPrice()) {
            foreach ($tcBillboardPrice as $k => $p) {
                if ($days >= $p['period']) {
                    $price = $p;
                }
            }
        }
        return $price;
    }


    /**
     * @param $date
     * @param string $format
     * @return false|string
     */
    public function dateFormat($date, $format = 'd.m.Y')
    {
        $date = date_create($date);
        return date_format($date, $format);
    }


    /**
     * Сравнить даты
     * $maxDate - максимальная дата
     * $minDate - минимальная дата
     * @param $maxDate
     * @param $minDate
     * @return bool
     */
    private function getDifference($maxDate, $minDate)
    {
        $result = false;
        if (strtotime($maxDate) < strtotime($minDate)) {
            $result = true;
        }
        return $result;
    }


    /**
     * Получить прайс
     *
     * @return array
     */
    public function getPrice()
    {
        $prices = array();

        $q = $this->modx->newQuery('tcBillboardPrice');
        $q->select('id, period, price, graceperiod, graceperiodprice, active');
        $q->where(array(
            'active' => 1,
        ));
        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $prices[$row['id']] = $row;
            }
        }
        return $prices;
    }


    /**
     * Получить количество дней публикации
     * $maxDate - максимальная дата
     * $minDate - минимальная дата
     * @param $minDate
     * @param $maxDate
     * @return int
     */
    public function countDate($minDate, $maxDate)
    {
        $min = new DateTime($minDate);
        $max = new DateTime($maxDate);
        $interval = $max->diff($min);
        return (int)$interval->format('%a');
    }


    /**
     * Записать даты в сессию
     *
     * @param $date
     * @param string $action
     * @return mixed
     */
    public function setSessionDate($date, $action = '', $mode = '')
    {
        unset($_SESSION['tcBillboard'][$action]);
        $_SESSION['tcBillboard'][$action] = array();
        switch ($mode) {
            case 'array':
                $_SESSION['tcBillboard'][$action] = $date;
                break;

            default:
                $_SESSION['tcBillboard'][$action] = trim($date);
                break;
        }
        return $_SESSION['tcBillboard'];
    }


    /**
     * @return mixed
     */
    public function getSession()
    {
        return $_SESSION['tcBillboard'];
    }


    /**
     * Записать способ оплаты в сессию
     *
     * @param $payment
     * @return array|string
     */
    public function setSessionPayment($payment, $redirect = false)
    {
        if (empty($payment)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                $this->modx->lexicon('tcbillboard_err_empty_payment'));
        }
        unset($_SESSION['tcBillboard']['payment']);

        $_SESSION['tcBillboard']['payment'] = array();
        $_SESSION['tcBillboard']['payment'] = $payment;

//        if ($redirect) {
//            $response = $this->redirectPayment($payment);
//            return $response;
//        }
        return $this->success('');
    }


    /**
     * Определяет куда редеректить после создания акции
     * $paymentId - ID метода оплаты
     * @param $paymentId
     * @return array|string
     */
//    public function redirectPayment($paymentId)
//    {
//        $data = array();
//        if ($paymentId == 1) {
//            $data['payment'] = $paymentId;
//            $data['redirect'] = $this->modx->makeUrl(
//                (int)$this->modx->getOption('tcbillboard_resource_form'),'','','full')
//                . '?payment=' . $paymentId;
//        }
//        return $this->success('', $data);
//    }


    /**
     * Если сумма заказа больше нуля, то отдаём чанк с благодарностью и банковскими
     * реквизитами.
     * $resId - ID созданного ресурса
     * @param $resId
     * @return string
     */
    public function chunkGratitude($resId)
    {
        $output = '';

        $order = $this->modx->getObject('tcBillboardOrders', array('res_id' => (int)$resId));
        $data = $order->toArray();
        if ($data['sum'] > 0) {
            $properties = $this->getSnippetProperties('tcBillboardForm');
            $output = $this->getChunk($properties['tplSuccessBank'], $data);
        }
        return $output;
    }


    /**
     * Получить среднее значение по каждому методу оплаты
     * @return string
     */
    public function getAverageOrders()
    {
        $bank = array();
        $payPal = array();
        $orders = array();
        $result = array();

        $q = $this->modx->newQuery('tcBillboardOrders');
        $q->select('payment');

        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['payment'] == 1) {
                    $bank[] = $row;
                } else if ($row['payment'] == 2) {
                    $payPal[] = $row;
                }
                $orders[] = $row;
            }
        }
        $avBank = count($bank);
        $avPayPal = count($payPal);
        $avOrders = count($orders);

        $result['bank'] = $avBank > 0 ? 100 / $avOrders * $avBank : 0;
        $result['PayPal'] = $avPayPal > 0 ? 100 / $avOrders * $avPayPal : 0;

        return json_encode($result);
    }


    /**
     * @param $chunk
     * @param array $properties
     * @return string
     */
    public function getChunk($chunk, $properties = array())
    {
        if ($this->pdoTools = $this->modx->getService('pdoTools')) {
            $response = $this->pdoTools->getChunk($chunk, $properties);
        } else {
            $response = $this->modx->getChunk($chunk, $properties);
        }
        return $response;
    }


    /**
     * Возвращает профиль пользователя
     * @return mixed
     */
    public function getUserProfile()
    {
        return $this->user;
    }


    /**
     * Удаляет указанную директорию
     * @param $path
     */
    public function removeDir($path, $options = array())
    {
        $this->runProcessor('browser/directory/remove', array('dir' => $path));
    }


    /**
     * Запускает указанный процессор
     * $action - путь для астивации тебуемого процессора
     * $data - данные
     * $options - опции
     * @param string $action
     * @param array $data
     * @return bool|mixed
     */
    public function runProcessor($action = '', $data = array(), $options = array())
    {
        if (empty($action)) {
            return false;
        }
        $this->modx->error->reset();

        return $this->modx->runProcessor($action, $data, $options);
    }


    /**
     * @param array $data
     * @param string $class
     * @return array|bool|string
     */
    public function fileUpload(array $data, $class = 'tcBillboard')
    {
        $properties = $this->getProperties($data['form_key']);

        if (!$this->authenticated || empty($properties['allowFiles'])) {
            return $this->error('tcbillboard_err_access_denied');
        }

        $data['source'] = $this->config['source'];
        $data['class'] = $class;
        // Получить ID старых файлов
        $oldsImg = $this->getOldImages($data);
        $processorsPath = MODX_CORE_PATH . 'components/tickets/processors/';

        $response = $this->runProcessor('web/file/upload', $data, array('processors_path' => $processorsPath));
        if ($response->isError()) {
            return $this->error($response->getMessage());
        }

        $file = $response->getObject();
        $file['size'] = round($file['size'] / 1024, 2);
        $file['new'] = empty($file['new']);
        // удалить старые файлы
        $this->fileDelete($oldsImg);

        if ($file['type'] != 'image') {
            return false;
        }
        return $this->success('', $file);
    }


    /**
     * Удаляет титульную картинку (ajax)
     * @param array $data
     * @param string $class
     * @return array|string
     */
    public function fileRemove(array $data, $class = 'tcBillboard')
    {
        $response = array();
        $response['photo'] = $this->getMaskTitulPath();

        if ($file = $this->modx->getObject('TicketFile', array(
            'class' => $class,
            'parent' => empty($data['value']) ? 0 : $data['value'],
            'source' => $this->config['source'],
            'createdby' => $this->user->id,
        ))) {
            $id = array($file->get('id'));
            if ($this->fileDelete($id)) {
                if ($photo = $this->user->photo) {
                    $response['photo'] = $photo;
                }
            }
        }
        return $this->success('', $response);
    }


    /**
     * Получить путь до заглушки, если нет титульной картинки
     * @return string
     */
    public function getMaskTitulPath()
    {
        return MODX_ASSETS_URL . 'components/tcbillboard/img/noImg.png';
    }


    /**
     * Получает ID старых файлов
     * @param array $properties
     * @param array $idsImgOld
     * @return array
     */
    public function getOldImages(array $properties, array $idsImgOld = array())
    {
        $q = $this->modx->newQuery('TicketFile');
        $q->select('id, parent, source, createdby');
        $q->where(array(
            'source' => $properties['source'],
            'parent' => !empty($properties['tid']) ? $properties['tid'] : 0,
            'createdby' => $this->modx->user->id,
        ));

        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $idsImgOld[] = $row['id'];
            }
        }
        return $idsImgOld;
    }


    /**
     * Ставит отметку deleted у старых файлов
     *
     * @param $ids
     * @return array|bool|string
     */
    public function fileDelete(array $ids)
    {
        if (!$this->authenticated ) {
            return $this->error('tcbillboard_err_access_denied');
        }

        foreach ($ids as $id) {
            if ($file = $this->modx->getObject('TicketFile', (int) $id)) {
                $file->set('deleted', 1);
                $file->save();
            } else {
                return $this->error('tcbillboard_err_get_object');
            }
        }
        return $this->success('');
    }


    /**
     * Получить все свойства формы
     *
     * @param $formId
     * @return mixed
     */
    public function getProperties($formId)
    {
        return $_SESSION['TicketForm'][$formId];
    }


    /**
     * @param string $message
     * @param array $data
     * @param array $placeholders
     * @return array|string
     */
    public function error($message = '', $data = array(), $placeholders = array())
    {
        $response = array(
            'success' => false,
            'message' => $this->modx->lexicon($message, $placeholders),
            'data' => $data,
        );
        return json_encode($response);
    }


    /**
     * @param string $message
     * @param array $data
     * @param array $placeholders
     * @return array|string
     */
    public function success($message = '', $data = array(), $placeholders = array())
    {
        $response = array(
            'success' => true,
            'message' => $this->modx->lexicon($message, $placeholders),
            'data' => $data,
        );
        return json_encode($response);
    }

}