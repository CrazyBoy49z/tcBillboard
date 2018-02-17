<?php

if (!class_exists('Mpdf')) {
    require dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php';
}

class MpdfTc
{
    /** @var tcBillboard $tcBillboard */
    protected $tcBillboard;
    /** @var modx $modx */
    protected $modx;
    /** @var \Mpdf\Mpdf $mpdf */
    protected $mpdf;


    public function __construct(tcBillboard $tcBillboard)
    {
        //$this->mpdf = new \Mpdf\Mpdf();
        $this->tcBillboard = $tcBillboard;
        $this->modx = $tcBillboard->modx;
    }


    /**
     * @param $path
     * @param $num
     * @param $html
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function createPdfFile($path, $num, $html)
    {
        ob_start();
        echo $html;
        $tmp = ob_get_contents();
        ob_end_clean();

        $this->mpdf = new \Mpdf\Mpdf();
        $siteName = $this->modx->getOption('site_name');

        $this->mpdf->SetProtection(array('print'));
        $this->mpdf->SetTitle($siteName . " - Invoice");
        $this->mpdf->SetAuthor($siteName);
        $this->mpdf->SetDisplayMode('fullpage');
        $this->mpdf->WriteHTML($tmp);


        $fileName = $num . '_' . date('d_G_i') . '.pdf';
        $pathPdf = $path . $fileName;
        $this->mpdf->Output($pathPdf, \Mpdf\Output\Destination::FILE);
        return $pathPdf;
    }
}