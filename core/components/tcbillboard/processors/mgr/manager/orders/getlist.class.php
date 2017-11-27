<?php

class tcBillboardOrdersGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'tcBillboardOrders';
    public $languageTopics = array('default', 'tcbillboard:manager');
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'msorder_list';
    /** @var  tcBillboard $tcBillboard */
    protected $tcBillboard;
    /** @var  xPDOQuery $query */
    protected $query;

    //protected $init;
    //protected $queryChart;


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

//        print_r($list);
//        die;

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
        //if ($this->getProperty('init')) {
        //    $this->init = $this->getProperty('init');
        //}

//        $c->leftJoin('modUserProfile', 'Profile', 'tcBillboardOrders.user_id = Profile.internalKey');
//        $c->leftJoin('tcBillboardPayment', 'Payment', 'tcBillboardOrders.payment = Payment.id');
//        $c->leftJoin('tcBillboardStatus', 'Status', 'tcBillboardOrders.status = Status.id');

//
//        $c->select($this->modx->getSelectColumns('tcBillboardOrders', 'tcBillboardOrders'));
//        $c->select($this->modx->getSelectColumns('modUserProfile', 'Profile', 'user_',
//            array(
//                'internalKey', 'fullname', 'email', 'phone', 'mobilephone', 'address', 'country', 'city'
//            )
//        ));
//        $c->select($this->modx->getSelectColumns('tcBillboardPayment', 'Payment', 'payment_',
//            array('name')
//        ));
//        $c->select($this->modx->getSelectColumns('tcBillboardStatus', 'Status', 'status_',
//            array('name', 'color')
//        ));

        //$c->leftJoin('modUser', 'User');
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
        //$array['notice'] = array();
        $array['actions'] = array();

        /*$array['notice'][] = array(
            'cls' => '',
            'icon' =>
        );*/

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

        /*if (!$array['active']) {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('tcbillboard_item_enable'),
                'multiple' => $this->modx->lexicon('tcbillboard_items_enable'),
                'action' => 'enableItem',
                'button' => true,
                'menu' => true,
            );
        } else {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('tcbillboard_item_disable'),
                'multiple' => $this->modx->lexicon('tcbillboard_items_disable'),
                'action' => 'disableItem',
                'button' => true,
                'menu' => true,
            );
        }*/

        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('tcbillboard_remove'),
            'multiple' => $this->modx->lexicon('tcbillboard_remove'),
            'action' => 'removeItem',
            'button' => true,
            'menu' => true,
        );

        return $array;
    }


    /**
     * @return array
     */
    /*public function getData()
    {
        $data = array();
        $limit = intval($this->getProperty('limit'));
        $start = intval($this->getProperty('start'));

        $c = $this->modx->newQuery($this->classKey);
        $c = $this->prepareQueryBeforeCount($c);
        $data['total'] = $this->modx->getCount($this->classKey, $c);
        $c = $this->prepareQueryAfterCount($c);

        $sortClassKey = $this->getSortClassKey();
        $sortKey = $this->modx->getSelectColumns($sortClassKey, $this->getProperty('sortAlias', $sortClassKey), '',
            array($this->getProperty('sort')));
        if (empty($sortKey)) {
            $sortKey = $this->getProperty('sort');
        }
        $c->sortby($sortKey, $this->getProperty('dir'));
        if ($limit > 0) {
            $c->limit($limit, $start);
        }

        if ($c->prepare() && $c->stmt->execute()) {
            $data['results'] = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }*/


    /*public function getData() {
        $data = array();
        $limit = intval($this->getProperty('limit'));
        $start = intval($this->getProperty('start'));*/

        /* query for chunks */
       /* $c = $this->modx->newQuery($this->classKey);
        $c = $this->prepareQueryBeforeCount($c);
        $data['total'] = $this->modx->getCount($this->classKey,$c);
        $c = $this->prepareQueryAfterCount($c);

        $sortClassKey = $this->getSortClassKey();
        $sortKey = $this->modx->getSelectColumns($sortClassKey,$this->getProperty('sortAlias',$sortClassKey),'',array($this->getProperty('sort')));
        if (empty($sortKey)) $sortKey = $this->getProperty('sort');
        $c->sortby($sortKey,$this->getProperty('dir'));
        if ($limit > 0) {
            $c->limit($limit,$start);
        }

        $data['results'] = $this->modx->getCollection($this->classKey,$c);
        return $data;
    }*/


    /**
     * @param array $data
     *
     * @return array
     */
    /*public function iterate(array $data)
    {
        $list = array();
        $list = $this->beforeIteration($list);
        $this->currentIndex = 0;*/
        /** @var xPDOObject|modAccessibleObject $object */
        /*foreach ($data['results'] as $array) {
            $list[] = $this->prepareArray($array);
            $this->currentIndex++;
        }
        $list = $this->afterIteration($list);

        return $list;
    }*/


    /**
     * @param array $data
     *
     * @return array
     */
    /*public function prepareArray(array $data)
    {
        if (empty($data['customer'])) {
            $data['customer'] = $data['customer_username'];
        }

        $data['status'] = '<span style="color:#' . $data['color'] . ';">' . $data['status'] . '</span>';
        unset($data['color']);

        if (isset($data['cost'])) {
            $data['cost'] = $this->ms2->formatPrice($data['cost']);
        }
        if (isset($data['cart_cost'])) {
            $data['cart_cost'] = $this->ms2->formatPrice($data['cart_cost']);
        }
        if (isset($data['delivery_cost'])) {
            $data['delivery_cost'] = $this->ms2->formatPrice($data['delivery_cost']);
        }
        if (isset($data['weight'])) {
            $data['weight'] = $this->ms2->formatWeight($data['weight']);
        }

        $data['actions'] = array(
            array(
                'cls' => '',
                'icon' => 'icon icon-edit',
                'title' => $this->modx->lexicon('ms2_menu_update'),
                'action' => 'updateOrder',
                'button' => true,
                'menu' => true,
            ),
            array(
                'cls' => array(
                    'menu' => 'red',
                    'button' => 'red',
                ),
                'icon' => 'icon icon-trash-o',
                'title' => $this->modx->lexicon('ms2_menu_remove'),
                'multiple' => $this->modx->lexicon('ms2_menu_remove_multiple'),
                'action' => 'removeOrder',
                'button' => true,
                'menu' => true,
            ),*/
            /*
            array(
                'cls' => '',
                'icon' => 'icon icon-cog actions-menu',
                'menu' => false,
                'button' => true,
                'action' => 'showMenu',
                'type' => 'menu',
            ),
            */
     /*   );

        return $data;
    }*/


    /**
     * @param array $array
     * @param bool $count
     *
     * @return string
     */
    /*public function outputArray(array $array, $count = false)
    {
        if ($count === false) {
            $count = count($array);
        }

        $selected = $this->query;
        $selected->query['columns'] = array();
        $selected->query['limit'] =
        $selected->query['offset'] = 0;
        $selected->where(array('type' => 0));
        $selected->select('SUM(msOrder.cost)');
        $selected->prepare();
        $selected->stmt->execute();

        $month = $this->modx->newQuery($this->classKey);
        $month->where(array('status:IN' => array(2, 3), 'type' => 0));
        $month->where('createdon BETWEEN NOW() - INTERVAL 30 DAY AND NOW()');
        $month->select('SUM(msOrder.cost) as sum, COUNT(msOrder.id) as total');
        $month->prepare();
        $month->stmt->execute();
        $month = $month->stmt->fetch(PDO::FETCH_ASSOC);

        $data = array(
            'success' => true,
            'results' => $array,
            'total' => $count,
            'num' => number_format($count, 0, '.', ' '),
            'sum' => number_format(round($selected->stmt->fetchColumn()), 0, '.', ' '),
            'month_sum' => number_format(round($month['sum']), 0, '.', ' '),
            'month_total' => number_format($month['total'], 0, '.', ' '),
        );

        return json_encode($data);
    }*/

}

return 'tcBillboardOrdersGetListProcessor';
