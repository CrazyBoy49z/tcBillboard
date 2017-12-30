<?php

class tcBillboardImportCSVProcessor extends modProcessor
{
    public $permission = 'tborder_import';

    /**
     * @return bool
     */
    public function checkPermissions() {
        return $this->modx->hasPermission($this->permission);
    }

    /**
     * @return array
     */
    public function getLanguageTopics() {
        return array('tcbillboard:default');
    }


    /**
     * @return array|mixed|string
     */
    public function process() {

        $csvFile = $this->getProperty('csv_data_file');
        $textField = trim($this->modx->getOption('tcbillboard_import_csv_text'));
        $amountField = trim($this->modx->getOption('tcbillboard_import_csv_amount'));
        $keyText = false;
        $keyAmount = false;
        $fileData = array();

        if(!empty($csvFile) && $csvFile['size'] > 0) {
            $fh = fopen($csvFile['tmp_name'], "r");
            while (($line = fgetcsv($fh, 1000, ";")) !== FALSE) {
                $fileData[] = $line;
            }
        }
        // Получить ключи необходимых названий колонок
        foreach ($fileData[0] as $key => $name) {
            if (trim($name) == $textField) {
                $keyText = $key;
            } elseif ($name == $amountField) {
                $keyAmount = $key;
            }
        }
        unset($fileData[0]);

        $total = count($fileData);
        $succeed = $failed = 1;
        foreach($fileData as $data) {
            if ($keyText && $keyAmount) {
                preg_match("#.*?(RE-20*[0-9 -]*)\b#", $data[$keyText], $matches);
                $this->updateOrder($matches[1], str_replace(',', '.', $data[$keyAmount]));
            } else {
                $failed++;
                $this->modx->log(modX::LOG_LEVEL_ERROR, $this->modx->lexicon('tcbillboard_err_text_amount'));
                continue;
            }
            $succeed++;
        }

        if(empty($total)) {
            return $this->failure($this->modx->lexicon('tcbillboard_import_failed'));
        }
        return $this->success($this->modx->lexicon('tcbillboard_import_success', array(
            'total' => $total,
            'succeed' => $succeed,
            'failed' => $failed,
        )));
    }


    /**
     * @param $invoice
     * @param $amount
     */
    private function updateOrder($invoice, $amount)
    {
        if ($order = $this->modx->getObject('tcBillboardOrders', array('num' => $invoice))) {
            //$order->set('paid', $order->get('paid') + $amount);
            $order->set('paid', $amount);
            $order->set('payment', 1);
            $order->set('status', 2);
            $order->set('paymentdate', time());
            $order->save();
        }
        return;
    }
}
return 'tcBillboardImportCSVProcessor';