<?php

class tcBillboardOrdersGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'tcBillboardOrders';
    public $languageTopics = array('default', 'tcbillboard:manager');
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    public $permission = 'tborder_list';
    /** @var  tcBillboard $tcBillboard */
    protected $tcBillboard;
    /** @var  xPDOQuery $query */
    protected $query;


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        $this->tcBillboard = $this->modx->getService('tcBillboard');

        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }
        return parent::initialize();
    }


    public function process() {
        $beforeQuery = $this->beforeQuery();
        if ($beforeQuery !== true) {
            return $this->failure($beforeQuery);
        }
        $data = $this->getData();

        if ($this->getProperty('init') == 'export') {
            $exportPath = $this->tcBillboard->exportPath();
            $fileName = 'tcBillboard-orders-' . date('d_m_Y_G_i') . '.csv';
            if (!is_dir($exportPath)) {
                mkdir($exportPath);
            }
            $list = $this->iterate($data);
            $list = $this->createCsv($exportPath, $fileName, $list);
        } else {
            $list = $this->iterate($data);
        }
        return $this->outputArray($list, $data['total']);
    }

    /**
     * @param $exportPath
     * @param $file
     * @param array $list
     * @return array
     */
    public function createCsv($exportPath, $file, array $list)
    {
        $download = $this->getProperty('download');

        $keys = array(
            'id' => 'ID',
            'num' => $this->modx->lexicon('tcbillboard_invoice'), // Счёт-фактура
            'createdon' => $this->modx->lexicon('tcbillboard_createdon'), // Дата заказа
            'user_fullname' => $this->modx->lexicon('tcbillboard_user_id'), // Заказчик
            'stock_name' => $this->modx->lexicon('tcbillboard_stock_name'), // Акция
            'sum' => $this->modx->lexicon('tcbillboard_account'), // Стоимость
            'payment_name' => $this->modx->lexicon('tcbillboard_payment'), // Оплата
            'status_name' => $this->modx->lexicon('tcbillboard_status'), // Статус
            'paymentdate' => $this->modx->lexicon('tcbillboard_paymentdate'), // Дата оплаты
            'pubdatedon' => $this->modx->lexicon('tcbillboard_pubdatedon'), // Дата публикации
            'unpubdatedon' => $this->modx->lexicon('tcbillboard_unpubdatedon'), // Отмена публикации
            'notice' => $this->modx->lexicon('tcbillboard_notice'), // Предупреждений
        );

        $handle = $exportPath . $file;
        if ($download) {
            ob_start();
            $handle = 'php://output';
        }
        $fp = fopen($handle, 'w');

        fputcsv($fp, $keys, ';');
        $tmp = array();
        foreach ($list as $order) {
            foreach ($keys as $key => $line) {
                if (array_key_exists($key, $order)) {
                    $tmp[$key] = $order[$key];
                }
            }
            fputcsv($fp, $tmp, ';');
        }

        fclose($fp);

        if ($download) {
            $str = ob_get_clean();
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="'.$file.'"');
            header("Pragma: no-cache");
            header("Expires: 0");
            echo "\xEF\xBB\xBF";
            echo $str;
            exit;
        }
        return array('file' =>$handle, 'filename' => $file, 'content' => ob_get_clean());
    }

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->leftJoin('modUserProfile', 'Profile');
        $c->leftJoin('tcBillboardStatus', 'Status');
        $c->leftJoin('tcBillboardPayment', 'Payment');

        $c->select(
            $this->modx->getSelectColumns('tcBillboardOrders', 'tcBillboardOrders', '', array('status', 'payment'), true) . ',
            Profile.fullname as user_fullname, Status.name as status_name, Status.color, Payment.name as payment_name'
        );
        if ($this->getProperty('details')) {
            $c->where(array(
                'id' => $this->getProperty('order_id'),
            ));
        }
        if ($date_start = $this->getProperty('date_start')) {
            $c->andCondition(array(
                'createdon:>=' => date('Y-m-d 00:00:00', strtotime($date_start)),
            ), null, 1);
        }
        if ($date_end = $this->getProperty('date_end')) {
            $c->andCondition(array(
                'createdon:<=' => date('Y-m-d 23:59:59', strtotime($date_end)),
            ), null, 1);
        }
        if ($chart = $this->getProperty('chart')) {
            $c->where(array(
                'payment' => $chart,
            ));
        }
        //$c->prepare();

        return $c;
    }

    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = array();

        // Edit
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('tcbillboard_update'),
            //'multiple' => $this->modx->lexicon('tcbillboard_items_update'),
            'action' => 'updateOrder',
            'button' => true,
            'menu' => true,
        );

        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('tcbillboard_remove'),
            'multiple' => $this->modx->lexicon('tcbillboard_remove'),
            'action' => 'removeOrder',
            'button' => true,
            'menu' => true,
        );
        return $array;
    }
}

return 'tcBillboardOrdersGetListProcessor';
